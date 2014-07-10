<?php
/**
* This file is part of the PhpStorm.
* (c) johann (johann_27@hotmail.fr)
*
* For the full copyright and license information, please view the LICENSE
* file that was distributed with this source code.
**/

namespace Certificationy\Bundle\CertyBundle\Process\Certification;

use Certificationy\Component\Certy\Model\Certification;
use Sylius\Bundle\FlowBundle\Process\Step\ControllerStep;

abstract class CertificationControllerStep extends ControllerStep
{
    /**
     * @var Certification
     */
    protected $certification;

    /**
     * @param Certification $certification
     */
    public function setCertification(Certification $certification)
    {
        $this->certification = $certification;
    }

}
