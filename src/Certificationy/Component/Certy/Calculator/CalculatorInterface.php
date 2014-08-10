<?php
 /**
 * This file is part of the Certificationy web platform.
 * (c) Johann Saunier (johann_27@hotmail.fr)
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 **/

namespace Certificationy\Component\Certy\Calculator;

use Certificationy\Component\Certy\Model\Certification;
use Psr\Log\LoggerInterface;

interface CalculatorInterface
{
    /**
     * @param LoggerInterface $logger
     *
     * @return mixed
     */
    public function setLogger(LoggerInterface $logger = null);

    /**
     * @param  Certification $certification
     * @return Certification
     */
    public function compute(Certification $certification);
}
