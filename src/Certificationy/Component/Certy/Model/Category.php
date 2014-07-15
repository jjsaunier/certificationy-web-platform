<?php
/**
* This file is part of the PhpStorm.
* (c) johann (johann_27@hotmail.fr)
*
* For the full copyright and license information, please view the LICENSE
* file that was distributed with this source code.
**/

namespace Certificationy\Component\Certy\Model;

use Behat\Transliterator\Transliterator;
use JMS\Serializer\Annotation\Type;

class Category
{
    /**
     * @var ModelCollection
     * @Type("ModelCollection<Certificationy\Component\Certy\Model\Question>")
     */
    protected $questions;

    /**
     * @var Certification
     * @Type("Certificationy\Component\Certy\Model\Certification")
     */
    protected $certification;

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
     * @param array $data
     *
     * @return Category
     */
    public static function __set_state(Array $data)
    {
        $category = new Category();
        $category->setLabel($data['label']);
        $category->setName($data['name']);
        $category->setQuestions($data['questions']);

        return $category;
    }
}
