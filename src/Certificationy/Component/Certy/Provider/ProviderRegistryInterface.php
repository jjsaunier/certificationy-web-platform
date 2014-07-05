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
    const OVERRIDE_STRATEGY = 1;
    const IGNORE_STRATEGY = 2;
    const EXCEPTION_STRATEGY = 3;

    /**
     * @param ProviderInterface $providers
     * @param string[]|string   $certificationName
     *
     * @throws \Exception
     * @return void
     */
    public function setProviders(Array $providers, $certificationName);

    /**
     * @return ProviderInterface[]
     */
    public function getProviders($certificationName);

    /**
     * @param $providerName
     * @param $certificationName
     *
     * @return mixed
     * @throws \Exception
     */
    public function getProvider($providerName, $certificationName);

    /**
     * @param $providerName
     * @param $certificationName
     *
     * @throws \Exception
     * @return void
     */
    public function removeProvider($providerName, $certificationName);

    /**
     * @param $providerName
     * @param $certificationName
     *
     * @return bool
     */
    public function isRegister($providerName, $certificationName);
}
