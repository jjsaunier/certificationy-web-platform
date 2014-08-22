<?php
 /**
 * This file is part of the Certificationy web platform.
 * (c) Johann Saunier (johann_27@hotmail.fr)
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 **/

namespace Certificationy\Component\Certy\Builder;

use Certificationy\Component\Certy\Context\CertificationContext;
use Certificationy\Component\Certy\Context\CertificationContextInterface;
use Certificationy\Component\Certy\Provider\ProviderInterface;

class ProviderBuilderPass extends AbstractBuilderPass
{
    /**
     * @var ProviderInterface
     */
    protected $provider;

    /**
     * @param ProviderInterface $provider
     */
    public function __construct(ProviderInterface $provider)
    {
        $this->provider = $provider;
    }

    /**
     * @param BuilderInterface              $builder
     * @param CertificationContextInterface $certificationContext
     */
    public function execute(BuilderInterface $builder, CertificationContextInterface $certificationContext)
    {
        $this->provider->load($certificationContext->getName());
        $this->collector->addResource($this->provider->getName(), $certificationContext->getName(), $this->provider->getResources());
    }
}
