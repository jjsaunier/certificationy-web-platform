<?php
 /**
 * This file is part of the Certificationy web platform.
 * (c) Johann Saunier (johann_27@hotmail.fr)
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 **/

namespace Certificationy\Bundle\GithubBundle\Bot\Common\Reaction;

use Certificationy\Bundle\GithubBundle\Api\Status\Status;
use Certificationy\Bundle\GithubBundle\Bot\Common\Action\SwitchCommitStatusAction;
use Certificationy\Bundle\GithubBundle\Bot\Common\BotActions;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;
use Symfony\Component\Routing\RouterInterface;

class SwitchCommitStatusReaction implements EventSubscriberInterface
{
    /**
     * @var \Symfony\Component\Routing\RouterInterface
     */
    protected $router;

    /**
     * @param RouterInterface $router
     */
    public function __construct(RouterInterface $router)
    {
        $this->router = $router;
    }

    /**
     * @return array
     */
    public static function getSubscribedEvents()
    {
        return [
            BotActions::SET_COMMIT_STATUS_ERROR => 'switchCommitToError',
            BotActions::SET_COMMIT_STATUS_FAILURE => 'switchCommitToFailure',
            BotActions::SET_COMMIT_STATUS_SUCCESS => 'switchCommitToSuccess',
            BotActions::SET_COMMIT_STATUS_PENDING => 'switchCommitToPending',
        ];
    }

    /**
     * @param array $content
     *
     * @return Status
     */
    protected function createStatus(array $content)
    {
        $status = new Status();

        $status->setUrl(
            $content['repository']['owner']['login'],
            $content['repository']['name'],
            $content['pull_request']['head']['sha']
        );

        return $status;
    }

    /**
     * @param array $content
     *
     * @return string
     */
    protected function createUrl(array $content)
    {
        return $this->router->generate(
            'github_inspection_commit',
            ['checksum' => $content['pull_request']['head']['sha']],
            UrlGeneratorInterface::ABSOLUTE_URL
        );
    }

    /**
     * @param SwitchCommitStatusAction $action
     */
    public function switchCommitToError(SwitchCommitStatusAction $action)
    {
        $status = $this->createStatus($content = $action->getData()['content']);

        $status->setOptions(Status::ERROR, $this->createUrl($content), $action->getMessage());

        $action->getClient()->send($status);
    }

    /**
     * @param SwitchCommitStatusAction $action
     */
    public function switchCommitToPending(SwitchCommitStatusAction $action)
    {
        $status = $this->createStatus($content = $action->getData()['content']);

        $status->setOptions(Status::PENDING, $this->createUrl($content), $action->getMessage());

        $action->getClient()->send($status);
    }

    /**
     * @param SwitchCommitStatusAction $action
     */
    public function switchCommitToSuccess(SwitchCommitStatusAction $action)
    {
        $status = $this->createStatus($content = $action->getData()['content']);

        $status->setOptions(Status::SUCCESS, $this->createUrl($content), $action->getMessage());

        $action->getClient()->send($status);
    }

    /**
     * @param SwitchCommitStatusAction $action
     */
    public function switchCommitToFailure(SwitchCommitStatusAction $action)
    {
        $status = $this->createStatus($content = $action->getData()['content']);

        $status->setOptions(Status::FAILURE, $this->createUrl($content), $action->getMessage());

        $action->getClient()->send($status);
    }
}
