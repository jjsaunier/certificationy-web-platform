<?php
/**
* This file is part of the PhpStorm.
* (c) johann (johann_27@hotmail.fr)
*
* For the full copyright and license information, please view the LICENSE
* file that was distributed with this source code.
**/

namespace Certificationy\Component\Certy\Tests\Collector;

use Certificationy\Component\Certy\Collector\Collector;
use Certificationy\Component\Certy\Collector\CollectorInterface;

class CollectorTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var CollectorInterface
     */
    protected $collector;

    protected function setUp()
    {
        $this->collector = new Collector();
        parent::setUp();
    }

    protected function tearDown()
    {
        $this->collector = null;
        parent::tearDown();
    }

    public function testAddResources()
    {
        $resource = $this->getMock('Certificationy\Component\Certy\Collector\ResourceInterface');

        $resources = [
            [ 'fooProvider', 'fooCertification', [ $resource, $resource, $resource ] ],
            [ 'fooProvider', 'fooCertification', [ $resource ] ],
            [ 'fooProvider', 'fooCertification', [ $resource ] ],
            [ 'barProvider', 'fooCertification', [ $resource ] ],
            [ 'barProvider', 'fooCertification', [ $resource ] ],
            [ 'barProvider', 'fooCertification', [ $resource ] ],
            [ 'barProvider', 'fooCertification', [ $resource ] ],
            [ 'barProvider', 'fooCertification', [ $resource ] ],
            [ 'barProvider', 'barCertification', [ $resource ] ],
            [ 'barProvider', 'barCertification', [ $resource ] ],
            [ 'barProvider', 'barCertification', [ $resource ] ],
            [ 'bazProvider', 'fooCertification', [ $resource ] ]
        ];

        foreach ($resources as $resourceNode) {
            list($providerName, $certificationName, $resources) = $resourceNode;

            $this->collector->addResource($providerName, $certificationName, $resources);
        }

        $resources = $this->collector->getResources();

        /**
         * We have 3 diffrent providers
         * fooProvider contains 1 certification (fooCertification) with 5 resources
         * barProvider contains 2 certification fooCertification => 5 resources, barCertification => 3 resources
         * bazProvider contains 1 certification fooCertification => 1 resource
         */

        //Check provider structure
        $this->assertCount(3, $resources);
        $this->assertArrayHasKey('fooProvider', $resources);
        $this->assertArrayHasKey('barProvider', $resources);
        $this->assertArrayHasKey('bazProvider', $resources);

        //Check inner provider structure
        $fooProvider = $resources['fooProvider'];
        $barProvider = $resources['barProvider'];
        $bazProvider = $resources['bazProvider'];
    }
}
