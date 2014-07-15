<?php
/**
* This file is part of the PhpStorm.
* (c) johann (johann_27@hotmail.fr)
*
* For the full copyright and license information, please view the LICENSE
* file that was distributed with this source code.
**/

namespace Certificationy\Component\Certy\Context;

interface CertificationContextInterface
{
    /**
     * @param string $name
     */
    public function __construct($name);

    /**
     * @param string $label
     */
    public function setLabel($label);

    /**
     * @return string
     */
    public function getLabel();
    /**
     * @param int $score
     */
    public function setScore($score);
    /**
     * @return int
     */
    public function getScore();

    /**
     * @param string[] $certifiedThreshold
     */
    public function setThreshold(Array $certifiedThreshold);

    /**
     * @param int    $score
     * @param string $thresholdName
     */
    public function addThreshold($score, $thresholdName);
    /**
     * @param $score
     */
    public function removeThreshold($score);

    /**
     * @return integer[]
     */
    public function getThreshold();

    /**
     * @param \string[] $excludeCategories
     */
    public function setExcludeCategories(Array $excludeCategories);

    /**
     * @param string $categoryName
     */
    public function addExcludeCategory($categoryName);

    /**
     * @param $categoryName
     *
     * @return mixed
     */
    public function removeExcludeCategory($categoryName);
    /**
     * @return string[]
     */
    public function getExcludeCategories();

    /**
     * @param int $numberOfQuestion
     */
    public function setNumberOfQuestions($numberOfQuestion);
    /**
     * @return int
     */
    public function getNumberOfQuestions();
    /**
     * @param string $language
     */
    public function setLanguage($language);

    /**
     * @return string
     */
    public function getLanguage();

    /**
     * @param boolean $debug
     */
    public function setDebug($debug);

    /**
     * @return boolean
     */
    public function getDebug();

    /**
     * @return string
     */
    public function getName();
}
