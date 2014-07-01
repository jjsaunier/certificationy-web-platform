<?php
/**
* This file is part of the PhpStorm.
* (c) johann (johann_27@hotmail.fr)
*
* For the full copyright and license information, please view the LICENSE
* file that was distributed with this source code.
**/

namespace Certificationy\Component\Certification\Dumper;

use Certificationy\Component\Certification\Dumper\Strategy\DumperStrategyInterface;

interface DumperInterface
{
    /**
     * @param DumperStrategyInterface $strategy
     *
     * @return mixed
     */
    public function addStrategy(DumperStrategyInterface $strategy);

    /**
     * @param string $strategyName
     */
    public function strategyIsEnabled($strategyName);

    /**
     * @param string $strategyName
     */
    public function dump($strategyName);
}
