<?php
/**
* This file is part of the PhpStorm.
* (c) johann (johann_27@hotmail.fr)
*
* For the full copyright and license information, please view the LICENSE
* file that was distributed with this source code.
**/

namespace Certificationy\Component\Certy\Tests\Builder;


use Certificationy\Component\Certy\Builder\ProviderBuilderPass;

class ProviderBuilderPassTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @return ProviderBuilderPass
     */
    public function testSetCollector()
    {
        $provider = $this->getMock('Certificationy\Component\Certy\Provider\ProviderInterface');
        $collector = $this->getMock('Certificationy\Component\Certy\Collector\CollectorInterface');
        $context = $this->getMock('Certificationy\Component\Certy\Context\CertificationContextInterface');

        $providerBuilderPass = new ProviderBuilderPass($provider, $context);
        $providerBuilderPass->setCollector($collector);

        $this->assertEquals(
            $collector,
            \PHPUnit_Framework_Assert::readAttribute($providerBuilderPass, 'collector')
        );

        return [$providerBuilderPass, $provider, $collector, $context];
    }

    /**
     * @depends testSetCollector
     */
    public function testExecute(Array $previousTestData)
    {
        list($providerBuilderPass, $provider, $collector, $context) = $previousTestData;

        $builder = $this->getMock('Certificationy\Component\Certy\Builder\BuilderInterface');

        $context->expects($this->any())
            ->method('getName')
            ->will($this->returnValue('Foo'))
        ;

        $provider->expects($this->any())
            ->method('getName')
            ->will($this->returnValue('Bar'))
        ;

        $provider->expects($this->any())
            ->method('getResources')
            ->will($this->returnValue(array()))
        ;

        $provider->expects($this->once())
            ->method('load')
            ->with($this->equalTo('Foo'))
        ;

        $collector->expects($this->once())
            ->method('addResource')
            ->with($this->equalTo('Bar'), $this->equalTo('Foo'), $this->equalTo(array()))
        ;

        $providerBuilderPass->execute($builder, $context);
    }
}