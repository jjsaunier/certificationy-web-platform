<?php
/**
* This file is part of the PhpStorm.
* (c) johann (johann_27@hotmail.fr)
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
    protected $providerCollection = array();

    /**
     * @var array
     */
    protected $scope = array();

    /**
     * @param ProviderInterface $provider
     * @param string[]|string   $certifications
     * @param int               $strategy
     *
     * @throws \Exception
     */
    public function addProvider(ProviderInterface $provider, $certificationsName, $strategy = self::OVERRIDE_STRATEGY)
    {
        $providerName = $provider->getName();

        if (!is_array($certificationsName)) {
            $certificationsName = (array) $certificationsName;
        }

        foreach ($certificationsName as $certificationName) {

            if (!isset($this->providerCollection[$certificationName])) {
                $this->providerCollection[$certificationName] = array();
            }

            $providerCollection =& $this->providerCollection[$certificationName];

            switch ($strategy) {
                case static::OVERRIDE_STRATEGY:
                    $providerCollection[$providerName] = $provider;
                    break;
                case static::IGNORE_STRATEGY:
                    if (!$this->isRegister($providerName, $certificationName)) {
                        $providerCollection[$providerName] = $provider;
                    }
                    break;
                case static::EXCEPTION_STRATEGY:
                    if ($this->isRegister($providerName, $certificationName)) {
                        throw new \Exception(sprintf('Provider %s is already register for certification', $providerName));
                    }
                    break;
                default:
                    throw new \Exception(sprintf('Unknown strategy %s', $strategy));
            }
        }
    }

    /**
     * @param ProviderInterface[] $providers
     */
    public function setProviders(Array $providers, $certificationName)
    {
        foreach ($providers as $provider) {
            $this->addProvider($provider, $certificationName);
        }
    }

    /**
     * @return ProviderInterface[]
     */
    public function getProviders($certificationName)
    {
        return $this->providerCollection[$certificationName];
    }

    /**
     * @param $providerName
     * @param $certificationName
     *
     * @return mixed
     * @throws \Exception
     */
    public function getProvider($providerName, $certificationName)
    {
        if (!$this->isRegister($providerName, $certificationName)) {
            throw new \Exception(sprintf('Provider %s does not exist for %s', $providerName, $certificationName));
        }

        return $this->providerCollection[$certificationName][$providerName];
    }

    /**
     * @param $providerName
     * @param $certificationName
     *
     * @throws \Exception
     */
    public function removeProvider($providerName, $certificationName)
    {
        if (!$this->isRegister($providerName, $certificationName)) {
            throw new \Exception(sprintf('Provider %s does not exist for %s', $providerName, $certificationName));
        }

        unset($this->providerCollection[$certificationName][$providerName]);

        if (empty($this->providerCollection[$certificationName])) {
            unset($this->providerCollection[$certificationName]);
        }
    }

    /**
     * @param $providerName
     * @param $certificationName
     *
     * @return bool
     */
    public function isRegister($providerName, $certificationName)
    {
        return isset($this->providerCollection[$certificationName][$providerName]);
    }
}
