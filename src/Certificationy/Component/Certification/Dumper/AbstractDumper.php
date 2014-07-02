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
use Certificationy\Component\Certification\Model\Certification;

abstract class AbstractDumper
{
    /**
     * @var \Certificationy\Component\Certification\Model\Certification
     */
    protected $certification;

    /**
     * @var \Certificationy\Component\Certification\Context\CertificationContext
     */
    protected $certificationContext;

    /**
     * @param Certification        $certification
     * @param CertificationContext $certificationContext
     */
    public function __construct(
        Certification $certification,
        CertificationContext $certificationContext
    ) {
        $this->certification = $certification;
        $this->certificationContext = $certificationContext;
    }

    /**
     * @param string $strategyName
     */
    public function dump()
    {
        return $this->doDump();
    }

    /**
     * @return mixed
     */
    protected function doDump()
    {
        return '';
    }
}
