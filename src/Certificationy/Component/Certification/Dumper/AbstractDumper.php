<?php
/**
* This file is part of the PhpStorm.
* (c) johann (johann_27@hotmail.fr)
*
* For the full copyright and license information, please view the LICENSE
* file that was distributed with this source code.
**/

namespace Certificationy\Component\Certification\Dumper;

use Certificationy\Component\Certification\Context\CertificationContext;
use Certificationy\Component\Certification\Dumper\Strategy\DumperStrategyInterface;
use Certificationy\Component\Certification\Model\Certification;

abstract class AbstractDumper implements DumperInterface
{
    /**
     * @var \Certificationy\Component\Certification\Model\Certification
     */
    private $certification;

    /**
     * @var \Certificationy\Component\Certification\Context\CertificationContext
     */
    private $certificationContext;

    /**
     * @var DumperStrategyInterface[]
     */
    private $strategies;

    /**
     * @param Certification        $certification
     * @param CertificationContext $certificationContext
     */
    public function __construct(Certification $certification, CertificationContext $certificationContext)
    {
        $this->certification = $certification;
        $this->certificationContext = $certificationContext;
        $this->strategies = array();
    }

    /**
     * @param DumperStrategyInterface $strategy
     */
    public function addStrategy(DumperStrategyInterface $strategy)
    {
        $this->strategies[$strategy->getName()] = $strategy;
    }

    /**
     * @param string $strategyName
     */
    public function strategyIsEnabled($strategyName)
    {
        return isset($this->strategies[$strategyName]);
    }

    /**
     * @param string $strategyName
     */
    public function dump($strategyName)
    {
        if (!$this->strategyIsEnabled($strategyName)) {
            throw new \Exception(sprintf(
                'Strategy %s is not available in [ %s ]',
                $strategyName,
                implode(', ', array_keys($this->strategies))));
        }

        $dumpStrategy = $this->strategies[$strategyName];
        $dumpStrategy->setCertification($this->certification);
        $dumpStrategy->setCertificationContext($this->certificationContext);

        $this->doDump($dumpStrategy);
    }

    /**
     * @param DumperStrategyInterface $dumperStrategy
     */
    protected function doDump(DumperStrategyInterface $dumperStrategy)
    {

    }
}
