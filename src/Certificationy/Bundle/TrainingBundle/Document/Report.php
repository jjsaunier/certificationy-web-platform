<?php
/**
* This file is part of the PhpStorm.
* (c) johann (johann_27@hotmail.fr)
*
* For the full copyright and license information, please view the LICENSE
* file that was distributed with this source code.
**/

namespace Certificationy\Bundle\TrainingBundle\Document;

use Doctrine\ODM\MongoDB\Mapping\Annotations as ODM;

/**
 * @ODM\Document
 */
class Report
{
    /** @ODM\Id("type=bin_uuid") */
    protected $id;

    /** @ODM\String */
    protected $name;

    /** @ODM\Int */
    protected $score;

    /** @ODM\Int*/
    protected $scoreRequired;

    /** @ODM\String */
    protected $level;

    /** @ODM\Int */
    protected $userId;

    /** @ODM\String */
    protected $label;

    /** @ODM\String */
    protected $language;

    /** @ODM\Field(type="hash") */
    protected $metrics;

    /** @ODM\Date */
    protected $createdAt;

    /** @ODM\Field(type="hash") */
    protected $excludedCategories;

    /**
     * @var int
     */
    protected $maxScore;

    public function __construct()
    {
        $this->createdAt = new \DateTime();
    }

    /**
     * @param string $language
     */
    public function setLanguage($language)
    {
        $this->language = $language;
    }

    /**
     * @return int
     */
    public function getMaxScore()
    {
        if (null === $this->maxScore) {

            $max = 0;
            foreach ($this->metrics as $node) {
                $max += $node['valid'];
                $max += $node['invalid'];
            }

            $this->maxScore = $max;
        }

        return $this->maxScore;
    }

    /**
     * @return string
     */
    public function getLanguage()
    {
        return $this->language;
    }

    /**
     * @param mixed $label
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
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param Array $metrics
     */
    public function setMetrics($metrics)
    {
        $this->metrics = $metrics;
    }

    /**
     * @return Array
     */
    public function getMetrics()
    {
        return $this->metrics;
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
     * @param int $score
     */
    public function setScore($score)
    {
        $this->score = $score;
    }

    /**
     * @return int
     */
    public function getScore()
    {
        return $this->score;
    }

    /**
     * @param string $level
     */
    public function setLevel($level)
    {
        $this->level = $level;
    }

    /**
     * @return string
     */
    public function getLevel()
    {
        return $this->level;
    }

    /**
     * @param int $userId
     */
    public function setUserId($userId)
    {
        $this->userId = $userId;
    }

    /**
     * @return int
     */
    public function getUserId()
    {
        return $this->userId;
    }

    /**
     * @param int $scoreRequired
     */
    public function setScoreRequired($scoreRequired)
    {
        $this->scoreRequired = $scoreRequired;
    }

    /**
     * @return \DateTime
     */
    public function getScoreRequired()
    {
        return $this->scoreRequired;
    }

    /**
     * @param mixed $createdAt
     */
    public function setCreatedAt(\DateTime $createdAt)
    {
        $this->createdAt = $createdAt;
    }

    /**
     * @return \DateTime
     */
    public function getCreatedAt()
    {
        return $this->createdAt;
    }

    /**
     * @param Array $excludedCategories
     */
    public function setExcludedCategories($excludedCategories)
    {
        $this->excludedCategories = $excludedCategories;
    }

    /**
     * @return Array
     */
    public function getExcludedCategories()
    {
        return $this->excludedCategories;
    }
}
