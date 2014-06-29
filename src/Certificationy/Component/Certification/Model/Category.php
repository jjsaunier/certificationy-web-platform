<?php
/**
* This file is part of the PhpStorm.
* (c) johann (johann_27@hotmail.fr)
*
* For the full copyright and license information, please view the LICENSE
* file that was distributed with this source code.
**/

namespace Certificationy\Component\Certification\Model;

class Category
{
    /**
     * @var ModelCollection
     */
    protected $questions;

    public function __construct()
    {
        $this->questions = new ModelCollection();
    }

    /**
     * @param Question $question
     */
    public function addQuestion(Question $question)
    {
        $this->questions->add($question);
    }

    /**
     * @return ModelCollection
     */
    public function getQuestions()
    {
        return $this->questions;
    }

    /**
     * @param ModelCollection $questions
     */
    public function setQuestions(ModelCollection $questions)
    {
        foreach($questions as $question){
            $this->addQuestion($question);
        }
    }

    /**
     * @param Question $question
     */
    public function removeQuestion(Question $question)
    {
        $this->questions->removeElement($question);
    }
} 