<?php
/**
* This file is part of the PhpStorm.
* (c) johann (johann_27@hotmail.fr)
*
* For the full copyright and license information, please view the LICENSE
* file that was distributed with this source code.
**/

namespace Certificationy\Bundle\GithubBundle\Bot;

use Certificationy\Bundle\GithubBundle\Api\Events;
use Certificationy\Bundle\GithubBundle\Bot\Certificationy\Action\CheckAction;
use Certificationy\Bundle\GithubBundle\Bot\Certificationy\Action\GitLocaleCloneAction;
use Certificationy\Bundle\GithubBundle\Bot\Certificationy\Action\PersistenceAction;
use Certificationy\Bundle\GithubBundle\Bot\Certificationy\ReviewerBotActions;
use Certificationy\Bundle\GithubBundle\Bot\Common\Action\SwitchCommitStatusAction;
use Certificationy\Bundle\GithubBundle\Bot\Common\Bot;
use Certificationy\Bundle\GithubBundle\Bot\Common\BotActions;
use Symfony\Component\EventDispatcher\EventDispatcher;
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
        return array(
            Events::PULL_REQUEST
        );
    }

    /**
     * 1 Set commit status to pending
     * 2 Clone the branch of fork who is pulled
     * 3 Check commit data
     * 4 Save report inside MongoDB
     * 5 Update commit status success|error|failure
     *
     * @param Request  $request
     * @param array    $data
     * @param Response $response
     *
     * @return Response
     */
    protected function doHandle(Request $request, array $data, Response $response)
    {
        switch ($data['event']) {
            case Events::PULL_REQUEST:
                try {
                    $this->doOnPullRequest($data);
                } catch ( \Exception $e) {
                    $this->actionDispatcher->dispatch(
                        BotActions::SET_COMMIT_STATUS_FAILURE,
                        new SwitchCommitStatusAction(
                            $this->client,
                            $data,
                            'The Certificationy CI build could not complete due to an error'
                        )
                    );

                    if (true === $data['debug']) {
                        throw $e;
                    }
                }
            break;
            case Events::PING:
                $response->setContent('PONG - '.$data['delivery_uuid']);
            break;
        }

        return $response;
    }

    /**
     * @param array $data
     */
    protected function doOnPullRequest(array $data)
    {
        //Set commit status to pending
        $this->actionDispatcher->dispatch(
            BotActions::SET_COMMIT_STATUS_PENDING,
            new SwitchCommitStatusAction($this->client, $data, 'Certificationy CI is currently working')
        );

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

        //Check certificationy
        $this->actionDispatcher->dispatch(
            ReviewerBotActions::CHECK,
            $checkAction = new CheckAction($this->client, $data, $basePath)
        );

        //Save in db (mongo)
        $this->actionDispatcher->dispatch(
            ReviewerBotActions::PERSIST,
            new PersistenceAction($this->client, $data, $checkAction->getErrors())
        );

        if (0 === $checkAction->getErrors()['total']) {
            $this->actionDispatcher->dispatch(
                BotActions::SET_COMMIT_STATUS_SUCCESS,
                new SwitchCommitStatusAction(
                    $this->client,
                    $data,
                    'Everything is OK, well done.'
                )
            );
        } else {
            $this->actionDispatcher->dispatch(
                BotActions::SET_COMMIT_STATUS_ERROR,
                new SwitchCommitStatusAction(
                    $this->client,
                    $data,
                    'The test as failed, please look details to correct it'
                )
            );
        }
    }
}
