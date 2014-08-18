<?php
/**
* This file is part of the PhpStorm.
* (c) johann (johann_27@hotmail.fr)
*
* For the full copyright and license information, please view the LICENSE
* file that was distributed with this source code.
**/

namespace Certificationy\Bundle\GithubBundle\Bot\Certificationy\Reaction;

use Certificationy\Bundle\GithubBundle\Bot\Certificationy\Action\GitLocaleCloneAction;
use Certificationy\Bundle\GithubBundle\Bot\Common\LoggerTrait;
use Certificationy\Bundle\GithubBundle\Bot\Common\Reaction\LoggableReactionInterface;
use Psr\Log\LoggerInterface;
use Symfony\Component\Process\Process;

class GitLocaleCloneReaction implements LoggableReactionInterface
{
    use CheckReactionTrait, LoggerTrait;

    /**
     * @var string
     */
    protected $login;

    /**
     * @var string
     */
    protected $password;

    /**
     * @param string $login
     * @param string $password
     */
    public function __construct(
        $login,
        $password
    ) {
        $this->login = $login;
        $this->password = $password;
    }

    /**
     * @param GitLocaleCloneAction $action
     */
    public function perform(GitLocaleCloneAction $action)
    {
        $content = $action->getData()['content'];

        if (true === $action->getData()['debug']) {

            $url = sprintf(
                'https://%s:%s@github.com/%s/test-hook.git',
                $this->login,
                $this->password,
                $this->login
            );

            $content['pull_request']['head']['repo']['clone_url'] = $url;
        }

        $cmd = [];
        $cmd[] = 'cd analyze';
        $cmd[] = 'mkdir -p '.$content['pull_request']['head']['sha'];
        $cmd[] = 'cd '. $content['pull_request']['head']['sha'];
        $cmd[] = sprintf(
            'git clone -b %s %s',
            $content['pull_request']['head']['ref'],
            $content['pull_request']['head']['repo']['clone_url']
        );

        if(null !== $this->logger){
            $this->logger->debug(sprintf('Start command %s', implode(' && ', $cmd)));
        }

        $process = new Process(implode(' && ', $cmd));
        $process->setTimeout(360);
        $process->run();

        if (!$process->isSuccessful()) {
            if (null !== $this->logger) {
                $this->logger->error($process->getErrorOutput());
            }

            throw new \RuntimeException($process->getErrorOutput());
        }
    }
}
