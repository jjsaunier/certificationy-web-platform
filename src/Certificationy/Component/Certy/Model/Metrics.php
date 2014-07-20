<?php
/**
* This file is part of the PhpStorm.
* (c) johann (johann_27@hotmail.fr)
*
* For the full copyright and license information, please view the LICENSE
* file that was distributed with this source code.
**/

namespace Certificationy\Component\Certy\Model;

use JMS\Serializer\Annotation\Type;

class Metrics
{
    /**
     * @var int
     * @Type("integer")
     */
    protected $categoryCount;

    /**
     * @var int
     * @Type("integer")
     */
    protected $questionCount;

    /**
     * @var int
     * @Type("integer")
     */
    protected $answerCount;

    /**
     * @var array
     * @Type("array")
     */
    protected $reportMetrics;

    const CATEGORY = 1;
    const QUESTION = 2;
    const ANSWER = 3;

    public function __construct()
    {
        $this->categoryCount = 0;
        $this->questionCount = 0;
        $this->answerCount = 0;
        $this->reportMetrics = array();
    }

    /**
     * @param string $type
     * @param int    $count
     */
    public function increment($type, $count = 1)
    {
        switch ($type) {
            case self::CATEGORY:
                $this->categoryCount = $this->categoryCount + $count;
                break;
            case self::QUESTION:
                $this->questionCount = $this->questionCount + $count;
                break;
            case self::ANSWER:
                $this->answerCount = $this->answerCount + $count;
                break;
        }
    }

    /**
     * @param string $type
     * @param int    $count
     */
    public function decrement($type, $count = 1)
    {
        switch ($type) {
            case self::CATEGORY:
                $this->categoryCount = $this->categoryCount - $count;
                break;
            case self::QUESTION:
                $this->questionCount = $this->questionCount - $count;
                break;
            case self::ANSWER:
                $this->answerCount = $this->answerCount - $count;
                break;
        }
    }

    /**
     * @param Category $category
     * @param Question $question
     */
    public function addReportMetrics(Category $category)
    {
        if (!isset($this->reportMetrics[$category->getName()])) {
            $this->reportMetrics[$category->getName()] = array(
                'valid' => 0,
                'invalid' => 0
            );
        }

        $currentReport =& $this->reportMetrics[$category->getName()];

        foreach ($category->getQuestions() as $question) {
            if ($question->isValid()) {
                $currentReport['valid']++;
            } else {
                $currentReport['invalid']++;
            }
        }
    }

    /**
     * @param Category $category
     *
     * @return bool
     */
    public function getReportMetrics(Category $category)
    {
        if (!isset($this->reportMetrics[$category->getName()])) {
            return false;
        }

        return $this->reportMetrics[$category->getName()];
    }

    /**
     * @return array
     */
    public function getAllReportMetrics()
    {
        return $this->reportMetrics;
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
     * @return Metrics
     */
    public static function __set_state(array $data)
    {
        $metrics = new Metrics();
        $metrics->setCategoryCount($data['categoryCount']);
        $metrics->setQuestionCount($data['questionCount']);
        $metrics->setAnswerCount($data['answerCount']);

        return $metrics;
    }
}
