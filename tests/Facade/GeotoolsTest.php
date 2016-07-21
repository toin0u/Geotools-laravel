<?php

/**
 * This file is part of the Geotools-laravel library.
 *
 * (c) Antoine Corcy <contact@sbin.dk>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Toin0u\Tests\Geotools\Facade;

/**
 * @author Antoine Corcy <contact@sbin.dk>
 */
class GeotoolsTest extends \Toin0u\Tests\Geotools\TestCase
{
    public function testCoordinate()
    {
        $this->assertInstanceOf('League\\Geotools\\Coordinate\\Coordinate', \Geotools::coordinate('1, 2'));
    }

    public function testDistance()
    {
        $this->assertInstanceOf('League\\Geotools\\Distance\\Distance', \Geotools::Distance());
    }

    public function testVertex()
    {
        $this->assertInstanceOf('League\\Geotools\\Vertex\\Vertex', \Geotools::Vertex());
    }

    public function testBatch()
    {
        $geocoder = new \Geocoder\ProviderAggregator();

        $this->assertInstanceOf('League\\Geotools\\Batch\\Batch', \Geotools::Batch($geocoder));
    }

    public function testGeohash()
    {
        $this->assertInstanceOf('League\\Geotools\\Geohash\\Geohash', \Geotools::Geohash());
    }

    public function testConvert()
    {
        $coordinate = \Geotools::coordinate('1, 2');

        $this->assertInstanceOf('League\\Geotools\\Convert\\Convert', \Geotools::Convert($coordinate));
    }
}
