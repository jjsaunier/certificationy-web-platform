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

    /**
     * @var Certification
     */
    protected $certification;

    /**
     * @var string
     */
    protected $label;

    /**
     * @var string
     */
    protected $name;

    public function __construct()
    {
        $this->questions = new ModelCollection();
    }

    /**
     * @param Certification $certification
     */
    public function setCertification(Certification $certification = null)
    {
        $this->certification = $certification;
    }

    /**
     * @return Certification
     */
    public function getCertification()
    {
        return $this->certification;
    }

    /**
     * @param Question $question
     */
    public function addQuestion(Question $question)
    {
        if (null === $question->getCategory()) {
            $question->setCategory($this);
        }

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
        foreach ($questions as $question) {
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

    /**
     * @param string $name
     */
    public function setLabel($name)
    {
        $this->label = $name;
    }

    /**
     * @return string
     */
    public function getLabel()
    {
        return $this->label;
    }

    /**
     * @param string $name
     */
    public function setName($name)
    {
        $this->name = $name;
    }

    /**
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @param array $data
     *
     * @return Category
     */
    public static function __set_state(Array $data)
    {
        $category = new Category();
        $category->setLabel($data['label']);
        $category->setName($data['name']);

        return $category;
    }
}
