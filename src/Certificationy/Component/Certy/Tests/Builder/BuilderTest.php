<?php
 /**
 * This file is part of the Certificationy web platform.
 * (c) Johann Saunier (johann_27@hotmail.fr)
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 **/

namespace Certificationy\Component\Certy\Tests\Builder;

use Certificationy\Component\Certy\Builder\Builder;
use Certificationy\Component\Certy\Collector\CollectorInterface;
use Certificationy\Component\Certy\Model\Certification;

class BuilderTest extends \PHPUnit_Framework_TestCase
{
    public function testCreateCertification()
    {
        $this->assertInstanceOf(Certification::CLASS, Builder::createCertification());
    }

    public function testBuild()
    {
        $collector = $this->getMock('Certificationy\Component\Certy\Collector\CollectorInterface');

        $context = $this->getMock('Certificationy\Component\Certy\Context\CertificationContextInterface');

        $builder = new Builder($collector);

        $builderPass = $this->getMockBuilder('Certificationy\Component\Certy\Builder\BuilderPassInterface')
            ->setMethods(['setCollector', 'execute'])
            ->getMock()
        ;

        $builderPass->expects($this->once())
            ->method('setCollector')
            ->with($this->callback(function($arg){
                return $arg instanceof CollectorInterface;
            }))
        ;

        $builderPass->expects($this->once())
            ->method('execute')
            ->with($this->identicalTo($builder), $this->identicalTo($context))
        ;

        $builder->addBuilderPass($builderPass);
        $certification = $builder->build($context);

        $this->assertInstanceOf(Certification::CLASS, $certification);
    }

    public function testAddBuilderPass()
    {
        $builderPass = $this->getMock('Certificationy\Component\Certy\Builder\BuilderPassInterface');

        $builder = new Builder();
        $builder->addBuilderPass($builderPass);

        $this->assertEquals(
            [$builderPass],
            \PHPUnit_Framework_Assert::readAttribute($builder, 'builderPass')
        );
    }

    public function testCollector()
    {
        $builder = new Builder();

        $this->assertInstanceOf(
            'Certificationy\Component\Certy\Collector\CollectorInterface',
            $builder->getCollector()
        );
    }

    /**
     *  Test this function now is a waste of time and pain, let's explode it before.
     */
    public function testNormalize()
    {

    }
}
