<?php
 /**
 * This file is part of the Certificationy web platform.
 * (c) Johann Saunier (johann_27@hotmail.fr)
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 **/

namespace Certificationy\Component\Certy\Context;

use Behat\Transliterator\Transliterator;
use JMS\Serializer\Annotation\Type;

class CertificationContext implements CertificationContextInterface
{
    /**
     * @var int
     * @Type("integer")
     */
    protected $numberOfQuestions;

    /**
     * @var string[]
     * @Type("array<string>")
     */
    protected $excludeCategories;

    /**
     * @var string[]
     * @Type("array<string>")
     */
    protected $excludeQuestions;

    /**
     * @var string
     * @Type("string")
     */
    protected $language;

    /**
     * @var int[]
     * @Type("array<integer>")
     */
    protected $threshold;

    /**
     * @var bool
     * @Type("boolean")
     */
    protected $debug;

    /**
     * @var string
     * @Type("string")
     */
    protected $name;

    /**
     * @var string
     * @Type("string")
     */
    protected $label;

    /**
     * @var int
     * @Type("integer")
     */
    protected $requiredScore;

    /**
     * @var string
     * @Type("string")
     */
    protected $level;

    /**
     * @var string[]
     * @Type("array<string>")
     */
    protected $availableLevels;

    /**
     * @var string[]
     * @Type("array<string>")
     */
    protected $availableLanguages;

    /**
     * @var bool
     * @Type("boolean")
     */
    protected $allowExcludeCategories;

    /**
     * @var bool
     * @Type("boolean")
     */
    protected $allowCustomNumberOfQuestions;

    /**
     * @var string
     * @Type("string")
     */
    protected $icons;

    /**
     * @param string $name
     */
    public function __construct($name)
    {
        $this->name = Transliterator::urlize($name);
        $this->threshold = [];
        $this->excludeCategories = [];
        $this->excludeQuestions = [];

        $this->initialized();
    }

    protected function initialized()
    {

    }

    /**
     * @param int $requiredScore
     */
    public function setRequiredScore($requiredScore)
    {
        $this->requiredScore = $requiredScore;
    }

    /**
     * @return int
     */
    public function getRequiredScore()
    {
        return $this->requiredScore;
    }

    /**
     * @param string $label
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
     * @param string[] $certifiedThreshold
     */
    public function setThreshold(array $certifiedThreshold)
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
    public function setExcludeCategories(array $excludeCategories)
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
    public function setExcludeQuestions(array $excludeQuestions)
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
     * @param \string[] $availableLevels
     */
    public function setAvailableLevels($availableLevels)
    {
        $this->availableLevels = $availableLevels;
    }

    /**
     * @return string[]
     */
    public function getAvailableLevels()
    {
        return $this->availableLevels;
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
     * @param \string[] $availableLanguages
     */
    public function setAvailableLanguages($availableLanguages)
    {
        $this->availableLanguages = $availableLanguages;
    }

    /**
     * @return string[]
     */
    public function getAvailableLanguages()
    {
        return $this->availableLanguages;
    }

    /**
     * @param boolean $allowExcludeCategories
     */
    public function setAllowExcludeCategories($allowExcludeCategories)
    {
        $this->allowExcludeCategories = $allowExcludeCategories;
    }

    /**
     * @return boolean
     */
    public function getAllowExcludeCategories()
    {
        return $this->allowExcludeCategories;
    }

    /**
     * @return bool
     */
    public function canBeCustomize()
    {
        if (1 < count($this->getAvailableLanguages())) {
            return true;
        }

        if (null !== $this->getAvailableLevels()) {
            return true;
        }

        if (true === $this->getAllowExcludeCategories()) {
            return true;
        }

        if (true === $this->getAllowCustomNumberOfQuestions()) {
            return true;
        }

        return false;
    }

    /**
     * @param boolean $allowCustomNumberOfQuestions
     */
    public function setAllowCustomNumberOfQuestions($allowCustomNumberOfQuestions)
    {
        $this->allowCustomNumberOfQuestions = $allowCustomNumberOfQuestions;
    }

    /**
     * @return boolean
     */
    public function getAllowCustomNumberOfQuestions()
    {
        return $this->allowCustomNumberOfQuestions;
    }

    /**
     * @param string $icons
     */
    public function setIcons($icons)
    {
        $this->icons = $icons;
    }

    /**
     * @return string
     */
    public function getIcons()
    {
        return $this->icons;
    }

    /**
     * @param array $data
     *
     * @return CertificationContext
     */
    public static function __set_state(array $data)
    {
        $certificationContext = new CertificationContext($data['name']);
        $certificationContext->setNumberOfQuestions($data['numberOfQuestions']);
        $certificationContext->setExcludeCategories($data['excludeCategories']);
        $certificationContext->setExcludeQuestions($data['excludeQuestions']);
        $certificationContext->setLanguage($data['language']);
        $certificationContext->setThreshold($data['threshold']);
        $certificationContext->setDebug($data['debug']);
        $certificationContext->setLabel($data['label']);
        $certificationContext->setAvailableLevels($data['availableLevels']);
        $certificationContext->setLevel($data['level']);
        $certificationContext->setAvailableLanguages($data['availableLanguages']);
        $certificationContext->setAllowExcludeCategories($data['allowExcludeCategories']);
        $certificationContext->setAllowCustomNumberOfQuestions($data['allowCustomNumberOfQuestions']);
        $certificationContext->setIcons($data['icons']);

        return $certificationContext;
    }
}
