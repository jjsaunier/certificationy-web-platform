<?php
/**
* This file is part of the PhpStorm.
* (c) johann (johann_27@hotmail.fr)
*
* For the full copyright and license information, please view the LICENSE
* file that was distributed with this source code.
**/

namespace Certificationy\Component\Certy\Model;

class Metrics
{
    /**
     * @var int
     */
    protected $categoryCount;

    /**
     * @var int
     */
    protected $questionCount;

    /**
     * @var int
     */
    protected $answerCount;

    const CATEGORY = 1;
    const QUESTION = 2;
    const ANSWER = 3;

    public function __construct()
    {
        $this->categoryCount = 0;
        $this->questionCount = 0;
        $this->answerCount = 0;
    }

    /**
     * @param int $type
     */
    public function increment($type)
    {
        switch($type){
            case self::CATEGORY:
                $this->categoryCount++;
            break;
            case self::QUESTION:
                $this->questionCount++;
            break;
            case self::ANSWER:
                $this->answerCount++;
            break;
        }
    }

    /**
     * @param int $type
     */
    public function decrement($type)
    {
        switch($type){
            case self::CATEGORY:
                $this->categoryCount--;
                break;
            case self::QUESTION:
                $this->questionCount--;
                break;
            case self::ANSWER:
                $this->answerCount--;
                break;
        }
    }

    /**
     * @param int $answerCount
     */
    public function setAnswerCount($answerCount)
    {
        $this->answerCount = $answerCount;
    }

    /**
     * @return int
     */
    public function getAnswerCount()
    {
        return $this->answerCount;
    }

    /**
     * @param int $categoryCount
     */
    public function setCategoryCount($categoryCount)
    {
        $this->categoryCount = $categoryCount;
    }

    /**
     * @return int
     */
    public function getCategoryCount()
    {
        return $this->categoryCount;
    }

    /**
     * @param int $questionCount
     */
    public function setQuestionCount($questionCount)
    {
        $this->questionCount = $questionCount;
    }

    /**
     * @return int
     */
    public function getQuestionCount()
    {
        return $this->questionCount;
    }

    /**
     * @param array $data
     *
     * @return Question
     */
    public static function __set_state(Array $data)
    {
        $metrics = new Metrics();
        $metrics->setCategoryCount($data['categoryCount']);
        $metrics->setQuestionCount($data['questionCount']);
        $metrics->setAnswerCount($data['answerCount']);

        return $metrics;
    }
}