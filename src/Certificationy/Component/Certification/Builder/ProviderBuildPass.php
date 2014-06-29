<?php
/**
* This file is part of the PhpStorm.
* (c) johann (johann_27@hotmail.fr)
*
* For the full copyright and license information, please view the LICENSE
* file that was distributed with this source code.
**/

namespace Certificationy\Component\Certification\Builder;

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
     */
    public function build(Builder $builder)
    {
        foreach($this->providerRegistry->getProviders() as $provider){

        }
    }
} 