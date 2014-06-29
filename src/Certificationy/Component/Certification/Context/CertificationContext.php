<?php
/**
* This file is part of the PhpStorm.
* (c) johann (johann_27@hotmail.fr)
*
* For the full copyright and license information, please view the LICENSE
* file that was distributed with this source code.
**/

namespace Certificationy\Component\Certification\Context;

class CertificationContext
{
    /**
     * @var int
     */
    protected $numberOfQuestion;

    /**
     * @var string[]
     */
    protected $excludeCategory;

    /**
     * @var string[]
     */
    protected $excludeQuestion;

    /**
     * @var int
     */
    protected $certifiedScore;

    /**
     * @var int[]
     */
    protected $certifiedThreshold;

    /**
     * @param int $certifiedScore
     */
    public function setCertifiedScore($certifiedScore)
    {
        $this->certifiedScore = $certifiedScore;
    }

    /**
     * @return int
     */
    public function getCertifiedScore()
    {
        return $this->certifiedScore;
    }

    /**
     * @param \int[] $certifiedThreshold
     */
    public function setCertifiedThreshold($certifiedThreshold)
    {
        $this->certifiedThreshold = $certifiedThreshold;
    }

    /**
     * @return \int[]
     */
    public function getCertifiedThreshold()
    {
        return $this->certifiedThreshold;
    }

    /**
     * @param \string[] $excludeCategory
     */
    public function setExcludeCategory($excludeCategory)
    {
        $this->excludeCategory = $excludeCategory;
    }

    /**
     * @return \string[]
     */
    public function getExcludeCategory()
    {
        return $this->excludeCategory;
    }

    /**
     * @param \string[] $excludeQuestion
     */
    public function setExcludeQuestion($excludeQuestion)
    {
        $this->excludeQuestion = $excludeQuestion;
    }

    /**
     * @return \string[]
     */
    public function getExcludeQuestion()
    {
        return $this->excludeQuestion;
    }

    /**
     * @param int $numberOfQuestion
     */
    public function setNumberOfQuestion($numberOfQuestion)
    {
        $this->numberOfQuestion = $numberOfQuestion;
    }

    /**
     * @return int
     */
    public function getNumberOfQuestion()
    {
        return $this->numberOfQuestion;
    }
} 