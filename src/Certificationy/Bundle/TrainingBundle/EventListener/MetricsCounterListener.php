<?php
/**
* This file is part of the PhpStorm.
* (c) johann (johann_27@hotmail.fr)
*
* For the full copyright and license information, please view the LICENSE
* file that was distributed with this source code.
**/

namespace Certificationy\Bundle\TrainingBundle\EventListener;

use Certificationy\Component\Certy\Events\CertificationEvent;
use Predis\Client;

class MetricsCounterListener
{
    /**
     * @var Client
     */
    protected $redisClient;

    /**
     * @param Client $redisClient
     */
    public function __construct(Client $redisClient)
    {
        $this->redisClient = $redisClient;
    }

    /**
     * @param CertificationEvent $event
     */
    public function increment(CertificationEvent $event)
    {
        $this->redisClient->incr('total');
        $this->redisClient->incr($event->getCertification()->getContext()->getName());

        $this->redisClient->bgsave();
    }
}
