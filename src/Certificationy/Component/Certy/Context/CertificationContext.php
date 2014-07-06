<?php
/**
* This file is part of the PhpStorm.
* (c) johann (johann_27@hotmail.fr)
*
* For the full copyright and license information, please view the LICENSE
* file that was distributed with this source code.
**/

namespace Certificationy\Component\Certy\Context;

class CertificationContext implements CertificationContextInterface
{
    /**
     * @var int
     */
    protected $numberOfQuestions;

    /**
     * @var string[]
     */
    protected $excludeCategories;

    /**
     * @var string[]
     */
    protected $excludeQuestions;

    /**
     * @var int
     */
    protected $score;

    /**
     * @var string
     */
    protected $language;

    /**
     * @var int[]
     */
    protected $threshold;

    /**
     * @var bool
     */
    protected $debug;

    /**
     * @vars string
     */
    protected $name;

    /**
     * @param string $name
     */
    public function __construct($name)
    {
        $this->name = $name;
        $this->threshold = array();
        $this->excludeCategories = array();
        $this->excludeQuestions = array();

        $this->initialized();
    }

    protected function initialized()
    {

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
     * @param string[] $certifiedThreshold
     */
    public function setThreshold(Array $certifiedThreshold)
    {
        foreach ($certifiedThreshold as $score => $thresholdName) {
            $this->addThreshold($score, $thresholdName);
        }
    }

    /**
     * @param int    $score
     * @param string $thresholdName
     */
    public function addThreshold($score, $thresholdName)
    {
        $this->threshold[$score] = $thresholdName;
    }

    /**
     * @param $score
     */
    public function removeThreshold($score)
    {
        unset($this->threshold[$score]);
    }

    /**
     * @return integer[]
     */
    public function getThreshold()
    {
        return $this->threshold;
    }

    /**
     * @param \string[] $excludeCategories
     */
    public function setExcludeCategories(Array $excludeCategories)
    {
        foreach ($excludeCategories as $categoryName) {
            $this->addExcludeCategory($categoryName);
        }
    }

    /**
     * @param string $categoryName
     */
    public function addExcludeCategory($categoryName)
    {
        $this->excludeCategories[$categoryName] = $categoryName;
    }

    /**
     * @param string $categoryName
     */
    public function removeExcludeCategory($categoryName)
    {
        unset($this->excludeCategories[$categoryName]);
    }

    /**
     * @return string[]
     */
    public function getExcludeCategories()
    {
        return $this->excludeCategories;
    }

    /**
     * @param \string[] $excludeQuestions
     */
    public function setExcludeQuestions(Array $excludeQuestions)
    {
        foreach ($excludeQuestions as $questionName) {
            $this->addExcludeQuestion($questionName);
        }
    }

    /**
     * @param string $questionName
     */
    public function addExcludeQuestion($questionName)
    {
        $this->excludeQuestions[] = $questionName;
    }

    /**
     * @param string $questionName
     */
    public function removeExcludeQuestion($questionName)
    {
        unset($this->excludeQuestions[$questionName]);
    }

    /**
     * @return string[]
     */
    public function getExcludeQuestions()
    {
        return $this->excludeQuestions;
    }

    /**
     * @param int $numberOfQuestion
     */
    public function setNumberOfQuestions($numberOfQuestion)
    {
        $this->numberOfQuestions = $numberOfQuestion;
    }

    /**
     * @return int
     */
    public function getNumberOfQuestions()
    {
        return $this->numberOfQuestions;
    }

    /**
     * @param string $language
     */
    public function setLanguage($language)
    {
        $this->language = $language;
    }

    /**
     * @return string
     */
    public function getLanguage()
    {
        return $this->language;
    }

    /**
     * @param boolean $debug
     */
    public function setDebug($debug)
    {
        $this->debug = $debug;
    }

    /**
     * @return boolean
     */
    public function getDebug()
    {
        return $this->debug;
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
     * @return CertificationContext
     */
    public static function __set_state(Array $data)
    {
        $certificationContext = new CertificationContext($data['name']);
        $certificationContext->setNumberOfQuestions($data['numberOfQuestions']);
        $certificationContext->setExcludeCategories($data['excludeCategories']);
        $certificationContext->setExcludeQuestions($data['excludeQuestions']);
        $certificationContext->setScore($data['score']);
        $certificationContext->setLanguage($data['language']);
        $certificationContext->setThreshold($data['threshold']);
        $certificationContext->setDebug($data['debug']);

        return $certificationContext;
    }
}
