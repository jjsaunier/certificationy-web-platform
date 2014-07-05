<?php
/**
* This file is part of the PhpStorm.
* (c) johann (johann_27@hotmail.fr)
*
* For the full copyright and license information, please view the LICENSE
* file that was distributed with this source code.
**/

namespace Certificationy\Component\Certy\Loader;

use Certificationy\Component\Certy\Model\Certification;

abstract class Loader implements LoaderInterface
{
    /**
     * @param $certificationName
     */
    public function load($certificationName)
    {

    }

    /**
     * @param mixed $certification
     */
    protected function validate($certification)
    {
        return $certification instanceof Certification;
    }
}
