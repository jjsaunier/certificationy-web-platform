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
use Certificationy\Component\Certy\Context\CertificationContext;
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

        $context = $this->getMockBuilder(CertificationContext::CLASS)
            ->disableOriginalConstructor()
            ->getMock()
        ;

        $builder = new Builder($collector);

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
