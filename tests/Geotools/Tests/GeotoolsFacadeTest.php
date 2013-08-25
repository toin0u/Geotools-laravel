<?php

/**
 * This file is part of the Geotools-laravel library.
 *
 * (c) Antoine Corcy <contact@sbin.dk>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Geotools\Tests;

/**
 * @author Antoine Corcy <contact@sbin.dk>
 */
class GeotoolsFacadeTest extends TestCase
{
    public function testCoordinate()
    {
        $this->assertInstanceOf('League\\Geotools\\Coordinate\\Coordinate', \Geotools::coordinate('1, 2'));
    }

    public function testDistance()
    {
        $this->assertInstanceOf('League\\Geotools\\Distance\\Distance', \Geotools::Distance());
    }

    public function testPoint()
    {
        $this->assertInstanceOf('League\\Geotools\\Point\\Point', \Geotools::Point());
    }

    public function testBatch()
    {
        $geocoder = new \Geocoder\Geocoder;

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
