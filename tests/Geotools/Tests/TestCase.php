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
class TestCase extends \Orchestra\Testbench\TestCase
{
    protected function getPackageProviders()
    {
        return array(
            'Toin0u\Geotools\GeotoolsServiceProvider',
        );
    }
    protected function getPackageAliases()
    {
        return array(
            'Geotools' => 'Toin0u\Geotools\GeotoolsFacade',
        );
    }
}
