<?php
 /**
 * This file is part of the Certificationy web platform.
 * (c) Johann Saunier (johann_27@hotmail.fr)
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 **/

namespace Certificationy\Bundle\GithubBundle\Bot\Certificationy\Action;

use Gundam\Component\Github\Client;
use Gundam\Component\Bot\Action\GenericAction;
use Symfony\Component\Stopwatch\StopwatchEvent;

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

    /**
     * @var \Symfony\Component\Stopwatch\StopwatchEvent
     */
    protected $stopwatchEvent;

    const TASK_START = 'task_start';

    const TASK_END = 'task_end';

    /**
     * @param Client         $client
     * @param array          $data
     * @param array          $errors
     * @param string         $status
     * @param StopwatchEvent $stopwatchEvent
     */
    public function __construct(
        Client $client,
        array $data,
        array $errors,
        $status,
        StopwatchEvent $stopwatchEvent = null
    ) {
        parent::__construct($client, $data);

        $this->errors = $errors;
        $this->status = $status;
        $this->stopwatchEvent = $stopwatchEvent;
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

    /**
     * @return StopwatchEvent
     */
    public function getStopwatchEvent()
    {
        return $this->stopwatchEvent;
    }
}
