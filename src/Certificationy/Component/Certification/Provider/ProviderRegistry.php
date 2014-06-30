<?php
/**
* This file is part of the PhpStorm.
* (c) johann (johann_27@hotmail.fr)
*
* For the full copyright and license information, please view the LICENSE
* file that was distributed with this source code.
**/

namespace Certificationy\Component\Certification\Provider;

class ProviderRegistry
{
    /**
     * @var ProviderInterface[]
     */
    protected $providers = array();

    /**
     * @param ProviderInterface $provider
     */
    public function addProvider(ProviderInterface $provider, $name)
    {
        $this->providers[$name] = $provider;
    }

    /**
     * @return ProviderInterface[]
     */
    public function getProviders()
    {
        return $this->providers;
    }

    /**
     * @param $name
     * @TODO: Create exception
     * @return ProviderInterface[]
     */
    public function getProvider($name)
    {
        return $this->providers[$name];
    }
}
