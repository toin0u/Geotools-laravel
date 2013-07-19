Geotools for Lavarel 4
======================

This package allows you to use [**Geotools**](http://geotools-php.org) in [**Laravel 4**](http://four.laravel.com/).


Installation
------------

It can be found on [Packagist](https://packagist.org/packages/toin0u/geotools-laravel).
The recommended way is through [composer](http://getcomposer.org).

Install composer:
```bash
$ curl -sS https://getcomposer.org/installer | php
$ php composer.phar require toin0u/geotools-laravel:@stable
```


Usage
-----

Find the `providers` key in `app/config/app.php` and register the **Geotools Service Provider**.

```php
'providers' => array(
    // ...

    'Toin0u\Geotools\GeotoolsServiceProvider',
)
```

Find the `aliases` key in `app/config/app.php` and register the **Geotools Facade**.

```php
'aliases' => array(
    // ...

    'Geotools' => 'Toin0u\Geotools\GeotoolsFacade',
)
```


Examples
--------

## Coordinate & Ellipsoid ##

```php
use League\Geotools\Coordinate\Ellipsoid;

// from an \Geocoder\Result\ResultInterface instance within Airy ellipsoid
$coordinate = Geotools::coordinate($geocoderResult, Ellipsoid::createFromName(Ellipsoid::AIRY));
// or in an array of latitude/longitude coordinate within GRS 1980 ellipsoid
$coordinate = Geotools::coordinate(array(48.8234055, 2.3072664), Ellipsoid::createFromName(Ellipsoid::GRS_1980));
// or in latitude/longitude coordinate within WGS84 ellipsoid
$coordinate = Geotools::coordinate('48.8234055, 2.3072664');
// or in degrees minutes seconds coordinate within WGS84 ellipsoid
$coordinate = Geotools::coordinate('48°49′24″N, 2°18′26″E');
// or in decimal minutes coordinate within WGS84 ellipsoid
$coordinate = Geotools::coordinate('48 49.4N, 2 18.43333E');
// the result will be:
printf("Latitude: %F\n", $coordinate->getLatitude()); // 48.8234055
printf("Longitude: %F\n", $coordinate->getLongitude()); // 2.3072664
printf("Ellipsoid name: %s\n", $coordinate->getEllipsoid()->getName()); // WGS 84
printf("Equatorial radius: %F\n", $coordinate->getEllipsoid()->getA()); // 6378136.0
printf("Polar distance: %F\n", $coordinate->getEllipsoid()->getB()); // 6356751.317598
printf("Inverse flattening: %F\n", $coordinate->getEllipsoid()->getInvF()); // 298.257224
printf("Mean radius: %F\n", $coordinate->getEllipsoid()->getArithmeticMeanRadius()); // 6371007.772533
```

[Read more...](http://geotools-php.org/#coordinate--ellipsoid)

## Convert ##

```php
$coordinate = Geotools::coordinate('40.446195, -79.948862');
$converted  = Geotools::convert($coordinate);
// convert to decimal degrees without and with format string
printf("%s\n", $converted->toDecimalMinutes()); // 40 26.7717N, -79 56.93172W
printf("%s\n", $converted->toDM('%P%D°%N %p%d°%n')); // 40°26.7717 -79°56.93172
// convert to degrees minutes seconds without and with format string
printf("%s\n", $converted->toDegreesMinutesSeconds('<p>%P%D:%M:%S, %p%d:%m:%s</p>')); // <p>40:26:46, -79:56:56</p>
printf("%s\n", $converted->toDMS()); // 40°26′46″N, 79°56′56″W
// convert in the UTM projection (standard format)
printf("%s\n", $converted->toUniversalTransverseMercator()); // 17T 589138 4477813
printf("%s\n", $converted->toUTM()); // 17T 589138 4477813 (alias)
```

[Read more...](http://geotools-php.org/#convert)

## Distance ##

```php
$coordA   = Geotools::coordinate(array(48.8234055, 2.3072664));
$coordB   = Geotools::coordinate(array(43.296482, 5.36978));
$distance = Geotools::distance()->setFrom($coordA)->setTo($coordB);

printf("%s\n",$distance->flat()); // 659166.50038742 (meters)
printf("%s\n",$distance->in('km')->haversine()); // 659.02190812846
printf("%s\n",$distance->in('mi')->vincenty()); // 409.05330679648
printf("%s\n",$distance->in('ft')->flat()); // 2162619.7519272
```

[Read more...](http://geotools-php.org/#distance)

## Point ##

```php
$coordA   = Geotools::coordinate(array(48.8234055, 2.3072664));
$coordB   = Geotools::coordinate(array(43.296482, 5.36978));
$point    =  Geotools::point()->setFrom($coordA)->setTo($coordB);

printf("%d\n", $point->initialBearing()); // 157 (degrees)
printf("%s\n", $point->initialCardinal()); // SSE (SouthSouthEast)
printf("%d\n", $point->finalBearing()); // 160 (degrees)
printf("%s\n", $point->finalCardinal()); // SSE (SouthSouthEast)

$middlePoint = $point->middle(); // \League\Geotools\Coordinate\Coordinate
printf("%s\n", $middlePoint->getLatitude()); // 46.070143125815
printf("%s\n", $middlePoint->getLongitude()); // 3.9152401085931

$destinationPoint = Geotools::point()->setFrom($coordA)->destination(180, 200000); // \League\Geotools\Coordinate\Coordinate
printf("%s\n", $destinationPoint->getLatitude()); // 47.026774650075
printf("%s\n", $destinationPoint->getLongitude()); // 2.3072664
```

[Read more...](http://geotools-php.org/#point)

## Geohash ##

```php
$coordToGeohash = Geotools::coordinate('43.296482, 5.36978');

// encoding
$encoded = Geotools::geohash()->encode($coordToGeohash, 4); // 12 is the default length / precision
// encoded
printf("%s\n", $encoded->getGeohash()); // spey
// encoded bounding box
$boundingBox = $encoded->getBoundingBox(); // array of \League\Geotools\Coordinate\CoordinateInterface
$southWest   = $boundingBox[0];
$northEast   = $boundingBox[1];
printf("http://www.openstreetmap.org/?minlon=%s&minlat=%s&maxlon=%s&maxlat=%s&box=yes\n",
    $southWest->getLongitude(), $southWest->getLatitude(),
    $northEast->getLongitude(), $northEast->getLatitude()
); // http://www.openstreetmap.org/?minlon=5.2734375&minlat=43.2421875&maxlon=5.625&maxlat=43.41796875&box=yes

// decoding
$decoded = Geotools::geohash()->decode('spey61y');
// decoded coordinate
printf("%s\n", $decoded->getCoordinate()->getLatitude()); // 43.296432495117
printf("%s\n", $decoded->getCoordinate()->getLongitude()); // 5.3702545166016
// decoded bounding box
$boundingBox = $decoded->getBoundingBox(); //array of \League\Geotools\Coordinate\CoordinateInterface
$southWest   = $boundingBox[0];
$northEast   = $boundingBox[1];
printf("http://www.openstreetmap.org/?minlon=%s&minlat=%s&maxlon=%s&maxlat=%s&box=yes\n",
    $southWest->getLongitude(), $southWest->getLatitude(),
    $northEast->getLongitude(), $northEast->getLatitude()
); // http://www.openstreetmap.org/?minlon=5.3695678710938&minlat=43.295745849609&maxlon=5.3709411621094&maxlat=43.297119140625&box=yes
```

[Read more...](http://geotools-php.org/#geohash)


Changelog
---------

[See the changelog file](https://github.com/toin0u/Geotools-laravel/blob/master/CHANGELOG.md)


Support
-------

[Please open an issues in github](https://github.com/toin0u/Geotools-laravel/issues)


License
-------

Geotools-laravel is released under the MIT License. See the bundled
[LICENSE](https://github.com/toin0u/Geotools-laravel/blob/master/LICENSE) file for details.
