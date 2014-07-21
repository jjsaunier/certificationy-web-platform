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

class Question
{
    /**
     * @var ModelCollection
     * @Type("ModelCollection<Certificationy\Component\Certy\Model\Answer>")
     */
    protected $answers;

    /**
     * @var Category
     * @Type("Certificationy\Component\Certy\Model\Category")
     *
     */
    protected $category;

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

    public function __construct()
    {
        $this->answers = new ModelCollection();
    }

    /**
     * @param string $name
     */
    public function setName($name)
    {
        $this->name = Transliterator::urlize($name);
    }

    /**
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @param ModelCollection $answers
     */
    public function setAnswers(ModelCollection $answers)
    {
        foreach ($answers as $answer) {
            $this->addAnswer($answer);
        }
    }

    /**
     * @param Category $category
     */
    public function setCategory(Category $category = null)
    {
        $this->category = $category;
    }

    /**
     * @return Category
     */
    public function getCategory()
    {
        return $this->category;
    }

    /**
     * @param Answer $answer
     */
    public function addAnswer(Answer $answer)
    {
        if (null === $answer->getQuestion()) {
            $answer->setQuestion($this);
        }

        $this->answers->add($answer);
    }

    /**
     * @return ModelCollection
     */
    public function getAnswers()
    {
        return $this->answers;
    }

    /**
     * @param Answer $answer
     */
    public function removeAnswer(Answer $answer)
    {
        $this->answers->removeElement($answer);
    }

    /**
     * @param string $label
     */
    public function setLabel($label)
    {
        $this->label = $label;
        $this->setName($label);
    }

    /**
     * @return string
     */
    public function getLabel()
    {
        return $this->label;
    }

    /**
     * @return ModelCollection
     */
    public function getAnswered()
    {
        return $this->answers->filter(function (Answer $answer) {
            if ($answer->isAnswered()) {
                return $answer;
            }
        });
    }

    /**
     * @return ModelCollection
     */
    public function getValidAnswers()
    {
        return $this->answers->filter(function (Answer $answer) {
            if ($answer->isValid()) {
                return $answer;
            }
        });
    }

    /**
     * @return bool
     */
    public function isValid()
    {
        if ($this->getAnswered()->isEmpty()) {
            return false;
        }

        return $this->getAnswered() == $this->getValidAnswers();
    }

    /**
     * @param  array    $data
     * @return Question
     */
    public static function __set_state(array $data)
    {
        $question = new Question();
        $question->setAnswers($data['answers']);
        $question->setLabel($data['label']);
        $question->setName($data['name']);

        return $question;
    }
}
