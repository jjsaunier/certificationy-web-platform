<?php
/**
* This file is part of the PhpStorm.
* (c) johann (johann_27@hotmail.fr)
*
* For the full copyright and license information, please view the LICENSE
* file that was distributed with this source code.
**/

namespace Certificationy\Component\Certification\Builder;

use Certificationy\Component\Certification\Context\CertificationContext;
use Certificationy\Component\Certification\Provider\ProviderRegistry;

class ProviderBuildPass implements BuilderPassInterface
{
    /**
     * @var \Certificationy\Component\Certification\Provider\ProviderRegistry
     */
    protected $providerRegistry;

    /**
     * @param ProviderRegistry $providerRegistry
     */
    public function __construct(ProviderRegistry $providerRegistry)
    {
        $this->providerRegistry = $providerRegistry;
    }

    /**
     * @param Builder $builder
     *
     * @return array
     */
    public function execute(Builder $builder, CertificationContext $certificationContext)
    {
        $data = array();

        foreach ($this->providerRegistry->getProviders() as $provider) {
            $data[$provider->getName()] = $provider->load();
        }

        return $data;
    }
}
