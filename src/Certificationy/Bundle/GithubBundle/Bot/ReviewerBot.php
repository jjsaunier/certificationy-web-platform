<?php
 /**
 * This file is part of the Certificationy web platform.
 * (c) Johann Saunier (johann_27@hotmail.fr)
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 **/

namespace Certificationy\Bundle\GithubBundle\Bot;

use Gundam\Component\Github\Events;
use Certificationy\Bundle\GithubBundle\Bot\Certificationy\Action\CheckAction;
use Certificationy\Bundle\GithubBundle\Bot\Certificationy\Action\GitLocaleCloneAction;
use Certificationy\Bundle\GithubBundle\Bot\Certificationy\Action\PersistenceAction;
use Certificationy\Bundle\GithubBundle\Bot\Certificationy\Action\RemoveFolderAction;
use Certificationy\Bundle\GithubBundle\Bot\Certificationy\ReviewerBotActions;
use Gundam\Component\Bot\Action\SwitchCommitStatusAction;
use Gundam\Component\Bot\Bot;
use Gundam\Component\Bot\BotActions;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

/**
 * Bot perform sequencially action(s) who trigger one or many reaction(s)
 */
class ReviewerBot extends Bot
{
    /**
     * @var string
     */
    protected $kernelRootDir;

    /**
     * @param string $kernelRootDir
     */
    public function setKernelRootDir($kernelRootDir)
    {
        $this->kernelRootDir = $kernelRootDir;
    }

    /**
     * @return string[]
     */
    public function getGithubEvents()
    {
        return [
            Events::PULL_REQUEST => 'onPullRequest'
        ];
    }

    /**
     * @param string   $eventName
     * @param Request  $request
     * @param array    $data
     * @param Response $response
     *
     * @return mixed
     * @throws \Exception
     */
    protected function doHandle($eventName, Request $request, array $data, Response $response)
    {
        if (Events::PULL_REQUEST === $eventName) {
            $this->closureEvent($eventName, $request, $data, $response);
        }

        return parent::doHandle($eventName, $request, $data, $response);
    }

    /**
     * @param string   $eventName
     * @param Request  $request
     * @param array    $data
     * @param Response $response
     *
     * @return Response
     * @throws \Exception
     */
    protected function closureEvent($eventName, Request $request, array $data, Response $response)
    {
        try {
            return parent::doHandle($eventName, $request, $data, $response);
        } catch ( \Exception $e) {

            if (null !== $this->logger) {
                $this->logger->error(sprintf(
                    'An error has been throw during the task for event %s, %s',
                    $eventName,
                    $e->getMessage()
                ), [ 'delivery_uuid' => $data['delivery_uuid']]);

                $this->logger->debug(sprintf(
                    'Set commit status failed on github',
                    $eventName
                ), [ 'delivery_uuid' => $data['delivery_uuid']]);
            }

            $this->actionDispatcher->dispatch(
                BotActions::SET_COMMIT_STATUS_FAILURE,
                new SwitchCommitStatusAction(
                    $this->client,
                    $data,
                    'The Certificationy CI build could not complete due to an error'
                )
            );

            if (null !== $this->logger) {
                $this->logger->debug(sprintf(
                    'Set commit status finished on certificationy'
                ), [ 'delivery_uuid' => $data['delivery_uuid']]);
            }

            //Save in db (mongo)
            $this->actionDispatcher->dispatch(
                ReviewerBotActions::PERSIST,
                new PersistenceAction($this->client, $data, ['total' => -1], PersistenceAction::TASK_END)
            );

            if (null !== $this->logger) {
                $this->logger->debug(sprintf(
                    'Perform clean'
                ), [ 'delivery_uuid' => $data['delivery_uuid']]);
            }

            //Clean up
            $this->actionDispatcher->dispatch(
                ReviewerBotActions::CLEAN,
                new RemoveFolderAction($this->client, $data)
            );

            if (true === $data['debug']) {

                if (null !== $this->logger) {
                    $this->logger->debug(sprintf(
                        'debug mode activated, throwing exception'
                    ), [ 'delivery_uuid' => $data['delivery_uuid']]);
                }

                throw $e;
            }
        }
    }

    /**
     * @param Request  $request
     * @param array    $data
     * @param Response $response
     *
     * @return Response
     */
    protected function onPullRequest(Request $request, array $data, Response $response)
    {
        return $this->doReview($request, $data, $response);
    }

    /**
     * 1 Set commit status to pending
     * 2 Save status in DB (mongo)
     * 3 Clone the branch of fork who is pulled
     * 4 Check commit data
     * 5 Save report inside MongoDB
     * 6 Update commit status success|error|failure
     *
     * @param Request  $request
     * @param array    $data
     * @param Response $response
     *
     * @return Response
     */
    protected function doReview(Request $request, array $data, Response $response)
    {
        if (null !== $this->logger) {
            $this->logger->debug(sprintf(
                'Set commit status pending on certificationy'
            ), [ 'delivery_uuid' => $data['delivery_uuid']]);
        }

        $persistenceAction = new PersistenceAction(
            $this->client,
            $data,
            ['total' => 0],
            PersistenceAction::TASK_START
        );

        //Save in db (mongo)
        $this->actionDispatcher->dispatch(ReviewerBotActions::PERSIST, $persistenceAction);

        $taskId = $persistenceAction->getTaskId();

        if (null !== $this->logger) {
            $this->logger->debug(sprintf(
                'Set commit status pending on github'
            ), [ 'delivery_uuid' => $data['delivery_uuid']]);
        }

        //Set commit status to pending
        $this->actionDispatcher->dispatch(
            BotActions::SET_COMMIT_STATUS_PENDING,
            new SwitchCommitStatusAction($this->client, $data, 'Certificationy CI is currently working')
        );

        if (null !== $this->logger) {
            $this->logger->debug(sprintf(
                'Clone locally'
            ), [ 'delivery_uuid' => $data['delivery_uuid']]);
        }

        //Clone locally last commit on pull request
        $this->actionDispatcher->dispatch(
            ReviewerBotActions::GIT_CLONE,
            new GitLocaleCloneAction($this->client, $data)
        );

        $basePath = sprintf(
            '%s/../web/analyze/%s/%s',
            $this->kernelRootDir,
            $data['content']['pull_request']['head']['sha'],
            $data['content']['pull_request']['head']['repo']['name']
        );

        if (null !== $this->logger) {
            $this->logger->debug(sprintf(
                'Check specification'
            ), [ 'delivery_uuid' => $data['delivery_uuid']]);
        }

        //Check certificationy
        $this->actionDispatcher->dispatch(
            ReviewerBotActions::CHECK,
            $checkAction = new CheckAction($this->client, $data, $basePath)
        );

        if (null !== $this->logger) {
            $this->logger->debug(sprintf(
                'Set commit status finished on certificationy'
            ), [ 'delivery_uuid' => $data['delivery_uuid']]);
        }

        $stopwatchEvent = $this->stopwatch->stop('bot');

        //Save in db (mongo)
        $this->actionDispatcher->dispatch(
            ReviewerBotActions::PERSIST,
            new PersistenceAction(
                $this->client,
                $data,
                $checkAction->getErrors(),
                PersistenceAction::TASK_END,
                $stopwatchEvent,
                $taskId
            )
        );

        if (0 === $checkAction->getErrors()['total']) {

            if (null !== $this->logger) {
                $this->logger->debug(sprintf(
                    'Set commit status successfull on github'
                ), [ 'delivery_uuid' => $data['delivery_uuid']]);
            }

            $this->actionDispatcher->dispatch(
                BotActions::SET_COMMIT_STATUS_SUCCESS,
                new SwitchCommitStatusAction(
                    $this->client,
                    $data,
                    'Everything is OK, well done.'
                )
            );
        } else {

            if (null !== $this->logger) {
                $this->logger->debug(sprintf(
                    'Set commit status is errored on github'
                ), [ 'delivery_uuid' => $data['delivery_uuid']]);
            }

            $this->actionDispatcher->dispatch(
                BotActions::SET_COMMIT_STATUS_ERROR,
                new SwitchCommitStatusAction(
                    $this->client,
                    $data,
                    'The test as failed, please look details to correct it'
                )
            );
        }

        if (null !== $this->logger) {
            $this->logger->debug(sprintf(
                'Perform clean'
            ), [ 'delivery_uuid' => $data['delivery_uuid']]);
        }

        //Clean up
        $this->actionDispatcher->dispatch(
            ReviewerBotActions::CLEAN,
            new RemoveFolderAction($this->client, $data)
        );

        return $response;
    }
}
