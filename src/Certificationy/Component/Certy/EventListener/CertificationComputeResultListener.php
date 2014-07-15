<?php
/**
* This file is part of the PhpStorm.
* (c) johann (johann_27@hotmail.fr)
*
* For the full copyright and license information, please view the LICENSE
* file that was distributed with this source code.
**/

namespace Certificationy\Component\Certy\EventListener;

use Certificationy\Component\Certy\Events\CertificationSubmissionEvent;
use Certificationy\Component\Certy\Calculator\CalculatorManager;

class CertificationComputeResultListener
{
    /**
     * @var CalculatorManager
     */
    protected $calculatorManager;

    /**
     * @param CalculatorManager $calculatorManager
     */
    public function __construct(CalculatorManager $calculatorManager)
    {
        $this->calculatorManager = $calculatorManager;
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

        $event->setCertification($calculator->compute($event->getCertification()));
    }
}
