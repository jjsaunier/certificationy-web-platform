<?php
 /**
 * This file is part of the Certificationy web platform.
 * (c) Johann Saunier (johann_27@hotmail.fr)
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 **/

namespace Certificationy\Component\Certy\Context;

interface CertificationContextInterface
{
    /**
     * @param string $name
     * @return void
     */
    public function __construct($name);

    /**
     * @param string $label
     * @return void
     */
    public function setLabel($label);

    /**
     * @return string
     */
    public function getLabel();

    /**
     * @param string[] $certifiedThreshold
     * @return void
     */
    public function setThreshold(array $certifiedThreshold);

    /**
     * @param int    $score
     * @param string $thresholdName
     * @return void
     */
    public function addThreshold($score, $thresholdName);
    /**
     * @param $score
     * @return void
     */
    public function removeThreshold($score);

    /**
     * @return integer[]
     */
    public function getThreshold();

    /**
     * @param \string[] $excludeCategories
     * @return void
     */
    public function setExcludeCategories(array $excludeCategories);

    /**
     * @param string $categoryName
     * @return void
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
     * @return void
     */
    public function setNumberOfQuestions($numberOfQuestion);
    /**
     * @return int
     */
    public function getNumberOfQuestions();
    /**
     * @param string $language
     * @return void
     */
    public function setLanguage($language);

    /**
     * @return string
     */
    public function getLanguage();

    /**
     * @param boolean $debug
     * @return void
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
