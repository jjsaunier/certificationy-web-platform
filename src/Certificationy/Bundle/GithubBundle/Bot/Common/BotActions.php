<?php
/**
* This file is part of the PhpStorm.
* (c) johann (johann_27@hotmail.fr)
*
* For the full copyright and license information, please view the LICENSE
* file that was distributed with this source code.
**/

namespace Certificationy\Bundle\GithubBundle\Bot\Common;

final class BotActions
{
    const SET_COMMIT_STATUS_PENDING = 'set.commit.status.pending';
    const SET_COMMIT_STATUS_SUCCESS = 'set.commit.status.success';
    const SET_COMMIT_STATUS_ERROR = 'set.commit.status.error';
    const SET_COMMIT_STATUS_FAILURE = 'set.commit.status.failure';
}
