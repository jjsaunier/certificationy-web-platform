<?php
/**
* This file is part of the PhpStorm.
* (c) johann (johann_27@hotmail.fr)
*
* For the full copyright and license information, please view the LICENSE
* file that was distributed with this source code.
**/

namespace Certificationy\Bundle\GithubBundle\Bot\Common\Reaction;


use Certificationy\Bundle\GithubBundle\Bot\Common\BotActions;
use GuzzleHttp\Event\SubscriberInterface;

class SwitchCommitStatusReaction implements SubscriberInterface
{
    /**
     * @return array
     */
    public function getEvents()
    {
        return array(
            BotActions::SET_COMMIT_STATUS_ERROR => 'switchCommitToError',
            BotActions::SET_COMMIT_STATUS_FAILURE => 'switchCommitToFailure',
            BotActions::SET_COMMIT_STATUS_SUCCESS => 'switchCommitToSuccess',
            BotActions::SET_COMMIT_STATUS_PENDING => 'switchCommitToPending',
        );
    }

    public function switchCommitToError()
    {

    }

    public function switchCommitToPending()
    {

    }

    public function switchCommitToSuccess()
    {

    }

    public function switchCommitToFailure()
    {

    }
} 