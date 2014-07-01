<?php
/**
* This file is part of the PhpStorm.
* (c) johann (johann_27@hotmail.fr)
*
* For the full copyright and license information, please view the LICENSE
* file that was distributed with this source code.
**/

namespace Certificationy\Component\Certification\Dumper\Strategy;

use Certificationy\Component\Certification\Context\CertificationContext;
use Certificationy\Component\Certification\Model\Certification;

interface DumperStrategyInterface
{
    /**
     * @return string
     */
    public function getName();

    /**
     * @param Certification $certification
     */
    public function setCertification(Certification $certification);

    /**
     * @param CertificationContext $certificationContext
     */
    public function setCertificationContext(CertificationContext $certificationContext);
}
