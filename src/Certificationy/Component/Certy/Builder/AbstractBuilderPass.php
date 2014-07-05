<?php
/**
* This file is part of the PhpStorm.
* (c) johann (johann_27@hotmail.fr)
*
* For the full copyright and license information, please view the LICENSE
* file that was distributed with this source code.
**/

namespace Certificationy\Component\Certy\Builder;

abstract class AbstractBuilderPass implements BuilderPassInterface
{
    /**
     * @var array
     */
    protected $providersResources;

    public function __construct()
    {
        $this->providersResources = array();
    }

    /**
     * @param string$providerName
     * @param array $resources
     */
    public function addProviderResources($providerName, Array $resources)
    {
        $this->providersResources[$providerName] = $resources;
    }

    /**
     * @return array
     */
    public function getProvidersResources()
    {
        return $this->providersResources;
    }

    /**
     * @param array $providersResources
     */
    public function setProvidersResources(Array $providersResources)
    {
        foreach ($providersResources as $providerName => $providerResources) {
            $this->addProviderResources($providerName, $providerResources);
        }
    }
}
