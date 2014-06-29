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

    public function __construct()
    {
        $this->answers = new ModelCollection();
    }

    /**
     * @param ModelCollection $answers
     */
    public function setAnswers(ModelCollection $answers)
    {
        foreach($answers as $answer){
            $this->answers->addAnswer($answer);
        }
    }

    /**
     * @param Answer $answer
     */
    public function addAnswer(Answer $answer)
    {
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
} 