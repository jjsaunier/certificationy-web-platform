<?php
namespace Certificationy\Bundle\CertyBundle;

use Certificationy\Bundle\CertyBundle\DependencyInjection\Compiler\BuilderCompilerPass;
use Certificationy\Bundle\CertyBundle\DependencyInjection\Compiler\ContextCompilerPass;
use Certificationy\Bundle\CertyBundle\DependencyInjection\Compiler\ProviderCompilerPass;
use Certificationy\Bundle\CertyBundle\DependencyInjection\Compiler\ScenarioCompilerPass;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\HttpKernel\Bundle\Bundle;

class CertificationyCertyBundle extends Bundle
{
    /**
     * @param ContainerBuilder $container
     */
    public function build(ContainerBuilder $container)
    {
        $container->addCompilerPass(new ProviderCompilerPass());
        $container->addCompilerPass(new BuilderCompilerPass());
        $container->addCompilerPass(new ContextCompilerPass());
        $container->addCompilerPass(new ScenarioCompilerPass());
    }
}
