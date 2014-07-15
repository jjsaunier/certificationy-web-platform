<?php
/**
* This file is part of the PhpStorm.
* (c) johann (johann_27@hotmail.fr)
*
* For the full copyright and license information, please view the LICENSE
* file that was distributed with this source code.
**/

namespace Certificationy\Component\Certy\Calculator\Delegator;

use Certificationy\Component\Certy\Model\Certification;

interface DelegatableInterface
{
    /**
     * @param $certification
     *
     * @return mixed
     */
    public function setCertification(Certification $certification);

    /**
     * @return \Certificationy\Component\Certy\Model\Certification
     */
    public function getCertification();
}
