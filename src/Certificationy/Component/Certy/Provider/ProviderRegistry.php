<?php
 /**
 * This file is part of the Certificationy web platform.
 * (c) Johann Saunier (johann_27@hotmail.fr)
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 **/

namespace Certificationy\Component\Certy\Provider;

class ProviderRegistry implements ProviderRegistryInterface
{
    /**
     * @var ProviderInterface[]
     */
    protected $providers = [];

    /**
     * @param ProviderInterface $provider
     */
    public function addProvider(ProviderInterface $provider)
    {
        $this->providers[$provider->getName()] = $provider;
    }

    /**
     * @param ProviderInterface[] $providers
     */
    public function setProviders(array $providers)
    {
        foreach ($providers as $provider) {
            $this->addProvider($provider);
        }
    }

    /**
     * @param string $providerName
     *
     * @return ProviderInterface
     * @throws \Exception
     */
    public function getProvider($providerName)
    {
        if (!$this->isRegister($providerName)) {
            throw new \Exception(sprintf('Provider %s does not exist', $providerName));
        }

        return $this->providers[$providerName];
    }

    /**
     * @param string $providerName
     *
     * @return bool
     */
    public function isRegister($providerName)
    {
        return isset($this->providers[$providerName]);
    }

    /**
     * @return integer[]
     */
    public function getRegistered()
    {
        return array_keys($this->providers);
    }
}
