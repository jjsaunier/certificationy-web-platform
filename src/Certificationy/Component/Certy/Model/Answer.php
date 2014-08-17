<?php
 /**
 * This file is part of the Certificationy web platform.
 * (c) Johann Saunier (johann_27@hotmail.fr)
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 **/

namespace Certificationy\Component\Certy\Model;

use Behat\Transliterator\Transliterator;
use JMS\Serializer\Annotation\Type;

class Answer
{
    /**
     * @var bool
     * @Type("boolean")
     */
    protected $expected;

    /**
     * @var Question
     * @Type("Certificationy\Component\Certy\Model\Question")
     */
    protected $question;

    /**
     * @var string
     * @Type("string")
     */
    protected $label;

    /**
     * @var string
     * @Type("string")
     */
    protected $name;

    /**
     * @var bool
     * @Type("boolean")
     */
    protected $answered;

    public function __construct()
    {
        $this->response = [];
    }

    /**
     * @param string $name
     */
    public function setName($name)
    {
        $this->name = Transliterator::urlize($name);

        if (empty($this->name)) { //Prevent answer label = '<?php', '!', '**' etc
            $this->name = md5($name);
        }
    }

    /**
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

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
        $this->setName($label);
        $this->label = $label;
    }

    /**
     * @return string
     */
    public function getLabel()
    {
        return $this->label;
    }

    public function setAsAnswered()
    {
        $this->answered = true;
    }

    /**
     * @return bool
     */
    public function isAnswered()
    {
        return $this->answered === true;
    }

    /**
     * @return bool
     */
    public function isValid()
    {
        return $this->expected === true;
    }

    /**
     * @param array $data
     *
     * @return Answer
     */
    public static function __set_state(array $data)
    {
        $answer = new Answer();
        $answer->setExpected($data['expected']);
        $answer->setLabel($data['label']);
        $answer->setName($data['name']);

        return $answer;
    }
}
