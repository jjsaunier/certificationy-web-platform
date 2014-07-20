<?php
/**
* This file is part of the PhpStorm.
* (c) johann (johann_27@hotmail.fr)
*
* For the full copyright and license information, please view the LICENSE
* file that was distributed with this source code.
**/

namespace Certificationy\Component\Certy\Provider;

interface ProviderRegistryInterface
{
    /**
     * @param ProviderInterface $provider
     * @return void
     */
    public function addProvider(ProviderInterface $provider);

    /**
     * @param ProviderInterface[] $providers
     * @return void
     */
    public function setProviders(array $providers);

    /**
     * @param string $providerName
     *
     * @return ProviderInterface
     * @throws \Exception
     */
    public function getProvider($providerName);

    /**
     * @param string $providerName
     *
     * @return bool
     */
    public function isRegister($providerName);

    /**
     * @return string[]
     */
    public function getRegistered();
}
