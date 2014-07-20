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

class ResultCertification
{
    /**
     * @var array
     * @Type("array")
     */
    protected $results;

    /**
     * @var int
     * @Type("integer")
     */
    protected $score;

    /**
     * @var bool
     * @Type("boolean")
     */
    protected $computed;

    /**
     */
    public function __construct()
    {
        $this->results = array();
        $this->computed = false;
        $this->score = 0;
    }

    /**
     * @param $result
     */
    public function setResults(array $results)
    {
        $this->assertIsComputed();

        foreach ($results as $result) {
            $this->addResult($result);
        }
    }

    /**
     * @param $result
     */
    public function addResult($result)
    {
        $this->assertIsComputed();

        $this->results[] = $result;
    }

    /**
     * @return array
     */
    public function getResults()
    {
        return $this->results;
    }

    /**
     * @return bool
     */
    public function isComputed()
    {
        return $this->computed === true;
    }

    /**
     * @throws \Exception
     */
    protected function assertIsComputed()
    {
        if ($this->isComputed()) {
            throw new \Exception("You can't modify results when the certification is computed");
        }
    }

    /**
     * @param int $score
     */
    public function setScore($score)
    {
        $this->computed = true;

        $this->score = $score;
    }

    /**
     * @return int
     */
    public function getScore()
    {
        if (!$this->isComputed()) {
            throw new \Exception("Score is not available, compute certification before");
        }

        return $this->score;
    }
}
