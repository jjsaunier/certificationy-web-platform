<?php
/**
* This file is part of the PhpStorm.
* (c) johann (johann_27@hotmail.fr)
*
* For the full copyright and license information, please view the LICENSE
* file that was distributed with this source code.
**/

namespace Certificationy\Component\Certification\Collector;

class Collector implements CollectorInterface
{
    /**
     * @var Resource[]
     */
    protected $resources;

    public function __construct()
    {
        $this->resources = array();
    }

    /**
     * @param array $resources
     */
    public function addResources(Array $resources)
    {
        var_dump($resources);
        exit;
    }

    /**
     * @return Resource[]
     */
    public function getResources()
    {
        return $this->resources;
    }

    /**
     * @return int
     */
    public function count()
    {
        return count($this->resources);
    }
} 