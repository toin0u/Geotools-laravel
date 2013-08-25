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
class GeotoolsServiceProviderTest extends TestCase
{
    public function testLoadedProviders()
    {
        $loadedProviders = $this->app->getLoadedProviders();

        $this->assertArrayHasKey('Toin0u\\Geotools\\GeotoolsServiceProvider', $loadedProviders);
        $this->assertTrue($loadedProviders['Toin0u\\Geotools\\GeotoolsServiceProvider']);
    }

    public function testGeotools()
    {
        $this->assertInstanceOf('League\\Geotools\\Geotools', $this->app['geotools']);
    }
}
