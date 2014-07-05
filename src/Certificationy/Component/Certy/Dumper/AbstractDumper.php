<?php
/**
* This file is part of the PhpStorm.
* (c) johann (johann_27@hotmail.fr)
*
* For the full copyright and license information, please view the LICENSE
* file that was distributed with this source code.
**/

namespace Certificationy\Component\Certy\Dumper;

use Certificationy\Component\Certy\Context\CertificationContext;
use Certificationy\Component\Certy\Model\Certification;

abstract class AbstractDumper implements DumperInterface
{
    /**
     * @var CertificationContext
     */
    protected $context;

    /**
     * @param Certification        $certification
     * @param CertificationContext $context
     *
     * @return mixed|string
     */
    /* final */ public function dump(Certification $certification, CertificationContext $context)
    {
        $this->context = $context;

        $certification = $this->doDump($certification);

        $this->context = null;

        return $certification;
    }

    /**
     * @param Certification $certification
     *
     * @return string
     */
    protected function doDump(Certification $certification)
    {
        return '';
    }
}
