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

interface DumperInterface
{
    /**
     * @param Certification $certification
     *
     * @return mixed
     */
    public function dump(Certification $certification, CertificationContext $context);
} 