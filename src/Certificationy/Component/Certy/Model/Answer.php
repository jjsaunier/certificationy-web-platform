<?php
/**
* This file is part of the PhpStorm.
* (c) johann (johann_27@hotmail.fr)
*
* For the full copyright and license information, please view the LICENSE
* file that was distributed with this source code.
**/

namespace Certificationy\Component\Certy\Model;

class Answer
{
    /**
     * @var bool
     */
    protected $expected;

    /**
     * @var Question
     */
    protected $question;

    /**
     * @var string
     */
    protected $label;

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

    /**
     * @return Question
     */
    public function getQuestion()
    {
        return $this->question;
    }

    /**
     * @param Question $question
     */
    public function setQuestion(Question $question = null)
    {
        $this->question = $question;
    }

    /**
     * @param boolean $expected
     */
    public function setExpected($expected)
    {
        $this->expected = $expected;
    }

    /**
     * @return boolean
     */
    public function getExpected()
    {
        return $this->expected;
    }

    /**
     * @param string $label
     */
    public function setLabel($label)
    {
        $this->label = $label;
    }

    /**
     * @return string
     */
    public function getLabel()
    {
        return $this->label;
    }

    /**
     * @param array $data
     *
     * @return Answer
     */
    public static function __set_state(Array $data)
    {
        $answer = new Answer();
        $answer->setExpected($data['expected']);
        $answer->setLabel($data['label']);

        return $answer;
    }
}
