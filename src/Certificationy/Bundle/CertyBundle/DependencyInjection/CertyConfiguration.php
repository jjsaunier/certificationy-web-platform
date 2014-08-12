<?php
 /**
 * This file is part of the Certificationy web platform.
 * (c) Johann Saunier (johann_27@hotmail.fr)
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 **/

namespace Certificationy\Bundle\CertyBundle\DependencyInjection;

use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\DependencyInjection\Definition;
use Symfony\Component\DependencyInjection\Reference;

class CertyConfiguration
{
    /**
     * @var \Symfony\Component\DependencyInjection\ContainerBuilder
     */
    protected $container;

    /**
     * @var array
     */
    public static $acceptedDelegator = [null, 'rabbitmq'];

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
    public function buildProvider(array $providerConfig)
    {
        if (isset($providerConfig['file'])) {
            $this->container->setParameter('certy_file_provider_root_dir', $providerConfig['file']['root_dir']);
        }
    }

    /**
     * @param array $calculatorConfig
     */
    public function buildCalculator(array $calculatorConfig)
    {
        //Register calculator service
        $calculatorDefinition = new Definition($calculatorConfig['class']);
        $calculatorDefinition
            ->addArgument(new Reference('event_dispatcher'))
            ->addMethodCall('setLogger', [new Reference('monolog.logger.certy', ContainerInterface::NULL_ON_INVALID_REFERENCE)])
        ;

        $this->container->setDefinition('certy.certificationy.calculator', $calculatorDefinition);

        //Register CalculatorManager
        $definition = new Definition('Certificationy\Component\Certy\Calculator\CalculatorManager');
        $definition->addArgument(new Reference('certy.certificationy.calculator'));

        if (null !== $delegator = $calculatorConfig['delegator']) {
            $this->getDelegator($delegator);
            $definition->addArgument(new Reference('certy.certification.delegator'));
        }

        $this->container->setDefinition('certy.certification.calculator_manager', $definition);
    }

    /**
     * @param string $delegatorName
     */
    protected function getDelegator($delegatorName)
    {
        if ('rabbitmq' === $delegatorName) {
            if (!class_exists('Swarrot\SwarrotBundle\SwarrotBundle')) {
                throw new \Exception('Delegate with RabbitMQ need SwarrotBundle to work, make sure he is enabled in appKernel.php');
            }

            if (!class_exists('JMS\SerializerBundle\JMSSerializerBundle')) {
                throw new \Exception('Delegate with RabbitMQ need JMS Serializer to communicate with worker');
            }

            $delegatorDefinition = new Definition('Certificationy\Component\Certy\Calculator\Delegator\RabbitMQ');
            $delegatorDefinition->setArguments([
                new Reference('swarrot.publisher'),
                new Reference('jms_serializer')
            ]);

            $processorDefinition = new Definition('Certificationy\Component\Certy\Calculator\Delegator\Processor\ResultComputeProcessor');
            $processorDefinition->setArguments([
                new Reference('jms_serializer'),
                new Reference('certy.certificationy.calculator')
            ]);

            $this->container->setDefinition('certy.certification.result_processor', $processorDefinition);

            $this->container->setDefinition('certy.certification.delegator', $delegatorDefinition);
        }
    }
}
