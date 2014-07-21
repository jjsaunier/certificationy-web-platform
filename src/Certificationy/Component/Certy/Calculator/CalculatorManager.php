<?php
 /**
 * This file is part of the Certificationy web platform.
 * (c) Johann Saunier (johann_27@hotmail.fr)
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 **/

namespace Certificationy\Component\Certy\Calculator;

use Certificationy\Component\Certy\Calculator\Delegator\DelegatableInterface;
use Certificationy\Component\Certy\Calculator\Delegator\DelegatorInterface;

class CalculatorManager
{
    /**
     * @var DelegatorInterface
     */
    protected $delegator;

    /**
     * @var CalculatorInterface
     */
    protected $calculator;

    /**
     * @param CalculatorInterface $calculator
     * @param DelegatorInterface  $delegator
     */
    public function __construct(CalculatorInterface $calculator, DelegatorInterface $delegator = null)
    {
        $this->delegator = $delegator;
        $this->calculator = $calculator;
    }

    /**
     * @return boolean
     */
    public function canDelegate()
    {
        return null !== $this->delegator;
    }

    /**
     * @param DelegatableInterface $object
     */
    public function delegate(DelegatableInterface $object)
    {
        $this->delegator->setDelegatedObject($object);
        $this->delegator->send();
    }

    /**
     * @return CalculatorInterface
     */
    public function getCalculator()
    {
        return $this->calculator;
    }
}
