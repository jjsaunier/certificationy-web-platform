<?php
/**
* This file is part of the PhpStorm.
* (c) johann (johann_27@hotmail.fr)
*
* For the full copyright and license information, please view the LICENSE
* file that was distributed with this source code.
**/

namespace Certificationy\Component\Certification\Model;

class Answer
{
    /**
     * @var string
     */
    protected $value;

    /**
     * @var bool
     */
    protected $expected;

    /**
     * @param $value
     *  true => correct
     *  false => incorrect
     * @return bool
     */
    public function evaluate($value)
    {
        return $value === $this->expected;
    }
}