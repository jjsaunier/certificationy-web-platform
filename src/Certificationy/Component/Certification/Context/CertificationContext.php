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
    protected $certificationScore;

    /**
     * @var string
     */
    protected $certificationLanguage;

    /**
     * @var int[]
     */
    protected $certificationThreshold;

    /**
     * @param int $certifiedScore
     */
    public function setCertificationScore($certifiedScore)
    {
        $this->certificationScore = $certifiedScore;
    }

    /**
     * @return int
     */
    public function getCertificationScore()
    {
        return $this->certificationScore;
    }

    /**
     * @param \int[] $certifiedThreshold
     */
    public function setCertificationThreshold($certifiedThreshold)
    {
        $this->certificationThreshold = $certifiedThreshold;
    }

    /**
     * @return \int[]
     */
    public function getCertificationThreshold()
    {
        return $this->certificationThreshold;
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

    /**
     * @param string $certificationLanguage
     */
    public function setCertificationLanguage($certificationLanguage)
    {
        $this->certificationLanguage = $certificationLanguage;
    }

    /**
     * @return string
     */
    public function getCertificationLanguage()
    {
        return $this->certificationLanguage;
    }
} 