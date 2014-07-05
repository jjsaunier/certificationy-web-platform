<?php
/**
* This file is part of the PhpStorm.
* (c) johann (johann_27@hotmail.fr)
*
* For the full copyright and license information, please view the LICENSE
* file that was distributed with this source code.
**/

namespace Certificationy\Bundle\CertyBundle\DependencyInjection;

use Symfony\Component\DependencyInjection\ContainerBuilder;

class CertyConfiguration
{
    /**
     * @var \Symfony\Component\DependencyInjection\ContainerBuilder
     */
    protected $container;

    /**
     * @param ContainerBuilder $container
     */
    public function __construct(ContainerBuilder $container)
    {
        $this->container = $container;
    }

    /**
     * @param array $providerConfig
     */
    public function buildProvider(Array $providerConfig)
    {
        if (isset($providerConfig['file'])) {
            $this->container->setParameter('certy_file_provider_root_dir', $providerConfig['file']['root_dir']);
        }
    }
}
