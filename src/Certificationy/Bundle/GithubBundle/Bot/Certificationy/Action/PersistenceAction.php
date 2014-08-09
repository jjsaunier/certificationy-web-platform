<?php
/**
* This file is part of the PhpStorm.
* (c) johann (johann_27@hotmail.fr)
*
* For the full copyright and license information, please view the LICENSE
* file that was distributed with this source code.
**/

namespace Certificationy\Bundle\GithubBundle\Bot\Certificationy\Action;

use Certificationy\Bundle\GithubBundle\Api\Client;
use Certificationy\Bundle\GithubBundle\Bot\Common\Action\GenericAction;

class PersistenceAction extends GenericAction
{
    /**
     * @var array
     */
    protected $errors;

    /**
     * @var string
     */
    protected $status;

    const TASK_START = 'task_start';

    const TASK_END = 'task_end';

    /**
     * @param Client $client
     * @param array  $data
     * @param array  $errors
     * @param       string $status
     */
    public function __construct(Client $client, array $data, array $errors, $status)
    {
        parent::__construct($client, $data);

        $this->errors = $errors;
        $this->status = $status;
    }

    /**
     * @return array
     */
    public function getErrors()
    {
        return $this->errors;
    }

    /**
     * @return string
     */
    public function getStatus()
    {
        return $this->status;
    }
}
