<?php
/**
* This file is part of the PhpStorm.
* (c) johann (johann_27@hotmail.fr)
*
* For the full copyright and license information, please view the LICENSE
* file that was distributed with this source code.
**/

namespace Certificationy\Component\Certy\Exception;


class NotAlreadyDumpedException extends Exception
{
    public function __construct($certificationyName)
    {
        parent::__construct(sprintf('Certification %s is not already dumped', $certificationyName));
    }
} 