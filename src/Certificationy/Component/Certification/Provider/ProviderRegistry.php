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

    const OVERRIDE_STRATEGY = 1;
    const IGNORE_STRATEGY = 2;
    const EXCEPTION_STRATEGY = 3;

    /**
     * @param ProviderInterface $provider
     */
    public function addProvider(ProviderInterface $provider, $providerName, $strategy = self::OVERRIDE_STRATEGY)
    {
        switch ($strategy) {
            case static::OVERRIDE_STRATEGY:
                $this->providers[$providerName] = $provider;
            break;
            case static::IGNORE_STRATEGY:
                if (!$this->isRegister($providerName)) {
                    $this->providers[$providerName] = $provider;
                }
            break;
            case static::EXCEPTION_STRATEGY:
                if ($this->isRegister($providerName)) {
                    throw new \Exception(sprintf('Provider %s is already register', $providerName));
                }
            break;
            default:
                throw new \Exception(sprintf('Unknown strategy %s', $strategy));
        }
    }

    /**
     * @param ProviderInterface[] $providers
     */
    public function setProviders(Array $providers)
    {
        $this->providers = $providers;
    }

    /**
     * @return ProviderInterface[]
     */
    public function getProviders()
    {
        return $this->providers;
    }

    /**
     * @param  string              $name
     * @return ProviderInterface[]
     */
    public function getProvider($providerName)
    {
        if (!$this->isRegister($providerName)) {
            throw new \Exception(sprintf('Provider %s does not exist', $providerName));
        }

        return $this->providers[$providerName];
    }

    /**
     * @param string $name
     */
    public function removeProvider($providerName)
    {
        if (!$this->isRegister($providerName)) {
            throw new \Exception(sprintf('Provider %s does not exist', $providerName));
        }

        unset($this->providers[$providerName]);
    }

    /**
     * @param $providerName
     *
     * @return bool
     */
    public function isRegister($providerName)
    {
        return isset($this->providers[$providerName]);
    }
}
