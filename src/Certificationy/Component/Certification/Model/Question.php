<?php
/**
* This file is part of the PhpStorm.
* (c) johann (johann_27@hotmail.fr)
*
* For the full copyright and license information, please view the LICENSE
* file that was distributed with this source code.
**/

namespace Certificationy\Component\Certification\Model;

class Question
{
    /**
     * @var ModelCollection
     */
    protected $answers;

    /**
     * @var Category
     */
    protected $category;

    /**
     * @var string
     */
    protected $label;

    public function __construct()
    {
        $this->answers = new ModelCollection();
    }

    /**
     * @param ModelCollection $answers
     */
    public function setAnswers(ModelCollection $answers)
    {
        foreach ($answers as $answer) {
            $this->answers->addAnswer($answer);
        }
    }

    /**
     * @param Category $category
     */
    public function setCategory(Category $category)
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
    }

    /**
     * @return string
     */
    public function getLabel()
    {
        return $this->label;
    }
}
