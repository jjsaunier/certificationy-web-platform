<?php
 /**
 * This file is part of the Certificationy web platform.
 * (c) Johann Saunier (johann_27@hotmail.fr)
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 **/

namespace Gundam\Component\Github;

final class Events
{
    const PULL_REQUEST = 'pull_request';
    const PING = 'ping';
    const PUSH = 'push';
    const DELETE = 'delete';
    const DEPLOYMENT = 'deployment';
    const COMMIT_COMMENT = 'commit_comment';
    const ISSUE_COMMENT = 'issue_comment';
    const FORK = 'fork';
    const MEMBER = 'member';
    const RELEASE = 'release';
    const PAGE_BUILD = 'page_build';
    const CREATE = 'create';
    const STATUS = 'status';
    const DEPLOYMENT_STATUS = 'deployment_status';
    const PULL_REQUEST_REVIEW_COMMENT = 'pull_request_review_comment';
    const ISSUES = 'issues';
    const WATCH = 'watch';
    const VISIBILITY = 'public';
    const TEAM_ADD = 'team_add';
    const GOLLUM = 'gollum';
}
