<?php
/**
* This file is part of the PhpStorm.
* (c) johann (johann_27@hotmail.fr)
*
* For the full copyright and license information, please view the LICENSE
* file that was distributed with this source code.
**/

namespace Certificationy\Component\Certy\Collector;

class Collector implements CollectorInterface
{
    /**
     * @var Resource[]
     */
    protected $resources;

    /**
     * @var string[]
     */
    protected $providersName;

    public function __construct()
    {
        $this->resources = array();
        $this->providersName = array();
    }

    /**
     * @param string $providerName
     * @param array  $resource
     */
    public function addResource($providerName, Array $resource)
    {
        if (!in_array($providerName, $this->providersName)) {
            $this->providersName[] = $providerName;
        }

        $this->resources = $this->resources + $resource;
    }

    /**
     * @param array $resources
     */
    public function setResources(Array $resources)
    {
        foreach ($resources as $providerName => $resource) {
            $this->addResource($providerName, $resource);
        }
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

    /**
     * @return string[]
     */
    public function getProvidersName()
    {
        return $this->providersName;
    }
}
