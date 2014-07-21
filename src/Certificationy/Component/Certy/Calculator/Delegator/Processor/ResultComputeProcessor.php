<?php
 /**
 * This file is part of the Certificationy web platform.
 * (c) Johann Saunier (johann_27@hotmail.fr)
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 **/

namespace Certificationy\Component\Certy\Calculator\Delegator\Processor;

use Certificationy\Component\Certy\Calculator\CalculatorInterface;
use JMS\Serializer\Serializer;
use Swarrot\Broker\Message;
use Swarrot\Processor\ProcessorInterface;

class ResultComputeProcessor implements ProcessorInterface
{
    /**
     * @var \JMS\Serializer\Serializer
     */
    protected $serializer;

    /**
     * @var \Certificationy\Component\Certy\Calculator\CalculatorInterface
     */
    protected $calculator;

    /**
     * @param Serializer          $serializer
     * @param CalculatorInterface $calculator
     */
    public function __construct(Serializer $serializer, CalculatorInterface $calculator)
    {
        $this->serializer = $serializer;
        $this->calculator = $calculator;
    }

    /**
     * @param Message $message
     * @param array   $options
     *
     * @return bool|void
     */
    public function process(Message $message, array $options)
    {
        $certification = $this->serializer->deserialize(
            $message->getBody(),
            'Certificationy\Component\Certy\Model\Certification',
            'json'
        );

        $this->calculator->compute($certification);
    }
}
