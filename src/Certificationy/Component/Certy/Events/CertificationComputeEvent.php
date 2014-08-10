<?php
/**
* This file is part of the PhpStorm.
* (c) johann (johann_27@hotmail.fr)
*
* For the full copyright and license information, please view the LICENSE
* file that was distributed with this source code.
**/

namespace Certificationy\Component\Certy\Events;


use Certificationy\Component\Certy\Model\Question;
use Symfony\Component\EventDispatcher\Event;

class CertificationComputeEvent extends Event
{
    /**
     * @var Question
     */
    protected $question;

    /**
     * @var
     */
    protected $skip;

    /**
     * @param Question $question
     */
    public function __construct(Question $question)
    {
        $this->question = $question;
        $this->skip = false;
    }

    public function skip()
    {
        $this->skip = true;
    }

    /**
     * @return bool
     */
    public function isSkipped()
    {
        return $this->skip;
    }
} 