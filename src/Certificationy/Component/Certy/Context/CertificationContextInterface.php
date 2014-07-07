<?php
/**
* This file is part of the PhpStorm.
* (c) johann (johann_27@hotmail.fr)
*
* For the full copyright and license information, please view the LICENSE
* file that was distributed with this source code.
**/

namespace Certificationy\Component\Certy\Context;

interface CertificationContextInterface
{
    /**
     * @return string
     */
    public function getName();

    /**
     * @return boolean
     */
    public function getDebug();
}
