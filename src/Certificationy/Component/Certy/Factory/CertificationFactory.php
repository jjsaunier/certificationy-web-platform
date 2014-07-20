<?php
/**
* This file is part of the PhpStorm.
* (c) johann (johann_27@hotmail.fr)
*
* For the full copyright and license information, please view the LICENSE
* file that was distributed with this source code.
**/

namespace Certificationy\Component\Certy\Factory;

use Certificationy\Component\Certy\Builder\BuilderInterface;
use Certificationy\Component\Certy\Builder\ProviderBuilderPass;
use Certificationy\Component\Certy\Context\CertificationContext;
use Certificationy\Component\Certy\Context\ContextRegistry;
use Certificationy\Component\Certy\Dumper\DumperInterface;
use Certificationy\Component\Certy\Loader\LoaderInterface;
use Certificationy\Component\Certy\Model\Certification;
use Certificationy\Component\Certy\Provider\ProviderInterface;
use Certificationy\Component\Certy\Provider\ProviderRegistryInterface;

class CertificationFactory
{
    /**
     * @var \Certificationy\Component\Certy\Loader\LoaderInterface|null
     */
    protected $loader;

    /**
     * @var \Certificationy\Component\Certy\Builder\Builder
     */
    protected $builder;

    /**
     * @var \Certificationy\Component\Certy\Provider\ProviderRegistryInterface
     */
    protected $providerRegistry;

    /**
     * @var \Certificationy\Component\Certy\Dumper\DumperInterface|null
     */
    protected $dumper;

    /**
     * @var ProviderInterface[]
     */
    protected $providers = array();

    /**
     * @param string               $name
     * @param CertificationContext $context
     * @param string[]             $providers
     *
     * @return Certification
     * @throws \Exception
     */
    public function createNamed($name, CertificationContext $context, array $providers)
    {
        if (empty($providers)) {
            throw new \Exception('You must define at least one provider');
        }

        if ($name !== $context->getName()) {
            throw new \Exception(sprintf('The current certification context is not for certification call %s', $name));
        }

        //Avoid to regenerate certification
        if (null !== $this->loader && false === $context->getDebug()) {
            return $this->loader->load($name);
        }

        //Check if required provider are loads
        foreach ($providers as $provider) {
            if (!$this->providerRegistry->isRegister($provider)) {
                throw new \Exception(sprintf(
                    'Provider %s is not registered. Did you mean %s',
                    $provider,
                    implode(', ', $this->providerRegistry->getRegistered())
                ));
            }
            $this->builder->addBuilderPass(new ProviderBuilderPass($this->providerRegistry->getProvider($provider)));
        }

        $certification = $this->builder->build($context);

        //Dump for next usage
        if (false === $context->getDebug() && null !== $this->dumper) {
            $this->dumper->dump($certification, $context);
        }

        return $certification;
    }

    /**
     * @param BuilderInterface $builder
     *
     * @return CertificationFactory
     */
    public function setBuilder(BuilderInterface $builder)
    {
        $this->builder = $builder;

        return $this;
    }

    /**
     * @param LoaderInterface $loader
     *
     * @return CertificationFactory
     */
    public function setLoader(LoaderInterface $loader)
    {
        $this->loader = $loader;

        return $this;
    }

    /**
     * @param ProviderRegistryInterface $providerRegistry
     *
     * @return CertificationFactory
     */
    public function setProviderRegistry(ProviderRegistryInterface $providerRegistry)
    {
        $this->providerRegistry = $providerRegistry;

        return $this;
    }

    /**
     * @param DumperInterface $dumper
     *
     * @return CertificationFactory
     */
    public function setDumper(DumperInterface $dumper)
    {
        $this->dumper = $dumper;

        return $this;
    }

    /**
     * @param ContextRegistry $contextRegistry
     */
    public function setContextRegistry(ContextRegistry $contextRegistry)
    {
        $this->contextRegistry = $contextRegistry;
    }
}
