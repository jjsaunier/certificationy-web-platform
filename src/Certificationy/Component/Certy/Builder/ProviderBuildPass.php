<?php
/**
* This file is part of the PhpStorm.
* (c) johann (johann_27@hotmail.fr)
*
* For the full copyright and license information, please view the LICENSE
* file that was distributed with this source code.
**/

namespace Certificationy\Component\Certy\Builder;

use Certificationy\Certification\Question;
use Certificationy\Component\Certy\Context\CertificationContext;
use Certificationy\Component\Certy\Provider\ProviderRegistry;

class ProviderBuildPass implements BuilderPassInterface
{
    /**
     * @var \Certificationy\Component\Certy\Provider\ProviderRegistry
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
     * @param Builder              $builder
     * @param CertificationContext $certificationContext
     *
     * @return Question[]
     */
    public function execute(Builder $builder, CertificationContext $certificationContext)
    {
        $data = array();

        foreach ($this->providerRegistry->getProviders($certificationContext->getName()) as $provider) {
            $data[$provider->getName()] = $provider->load();
        }

        return $data;
    }
}
