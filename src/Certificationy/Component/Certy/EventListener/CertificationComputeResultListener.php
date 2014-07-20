<?php
/**
* This file is part of the PhpStorm.
* (c) johann (johann_27@hotmail.fr)
*
* For the full copyright and license information, please view the LICENSE
* file that was distributed with this source code.
**/

namespace Certificationy\Component\Certy\EventListener;

use Certificationy\Component\Certy\Events\CertificationComputationEvent;
use Certificationy\Component\Certy\Events\CertificationEvents;
use Certificationy\Component\Certy\Events\CertificationSubmissionEvent;
use Certificationy\Component\Certy\Calculator\CalculatorManager;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;

class CertificationComputeResultListener
{
    /**
     * @var CalculatorManager
     */
    protected $calculatorManager;

    /**
     * @var EventDispatcherInterface
     */
    protected $eventDispatcher;

    /**
     * @param CalculatorManager        $calculatorManager
     * @param EventDispatcherInterface $eventDispatcher
     */
    public function __construct(CalculatorManager $calculatorManager, EventDispatcherInterface $eventDispatcher)
    {
        $this->calculatorManager = $calculatorManager;
        $this->eventDispatcher = $eventDispatcher;
    }

    /**
     * @param CertificationSubmissionEvent $event
     */
    public function onSubmission(CertificationSubmissionEvent $event)
    {
        if ($this->calculatorManager->canDelegate()) {
            $this->calculatorManager->delegate($event);

            return;
        }

        $calculator = $this->calculatorManager->getCalculator();
        $certification = $event->getCertification();

        $this->eventDispatcher->dispatch(CertificationEvents::CERTIFICATION_PRE_COMPUTATION, new CertificationComputationEvent($certification));
        $event->setCertification($calculator->compute($certification));
        $this->eventDispatcher->dispatch(CertificationEvents::CERTIFICATION_POST_COMPUTATION, new CertificationComputationEvent($certification));
    }
}
