<?php
/**
* This file is part of the PhpStorm.
* (c) johann (johann_27@hotmail.fr)
*
* For the full copyright and license information, please view the LICENSE
* file that was distributed with this source code.
**/

namespace Certificationy\Component\Certy\Calculator\Delegator;

use Certificationy\Component\Certy\Model\Certification;
use JMS\Serializer\Serializer;
use Psr\Log\LoggerInterface;
use Swarrot\Broker\Message;
use Swarrot\SwarrotBundle\Broker\Publisher;

class RabbitMQ implements DelegatorInterface
{
    /**
     * @var Certification
     */
    protected $certification;

    /**
     * @var Publisher
     */
    protected $publisher;

    /**
     * @var \JMS\Serializer\Serializer
     */
    protected $serializer;

    /**
     * @param Publisher            $publisher
     * @param Serializer           $serializer
     * @param LoggerInterface|null $logger
     */
    public function __construct(Publisher $publisher, Serializer $serializer)
    {
        $this->publisher = $publisher;
        $this->serializer = $serializer;
    }

    /**
     * @param DelegatableInterface $object
     */
    public function setDelegatedObject(DelegatableInterface $object)
    {
        if (null !== $certification = $object->getCertification()) {
            $this->certification = $certification;
        }
    }

    public function send()
    {
        $data = $this->serializer->serialize($this->certification, 'json');
        $this->publisher->publish('compute_certification', new Message($data));
    }
}
