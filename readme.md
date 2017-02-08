# DistanceMatrix PHP API Wrapper

Very simple API Wrapper for Google's DistanceMatrix API. Enter two addresses and the class returns the distance between them in meter. Alternatively use Google Static Map API to generate a map with a line plotted between two adresses.

## Install

Install using composer:

```
$ composer require martijnoud/distancematrix
```

## Basic usage
Calculate the distance in meters between the [Inktweb.nl office](https://www.inktweb.nl/) and Paleis Noordeinde in the Hague.
```php
use MartijnOud\DistanceMatrix\DistanceMatrix;

$distanceMatrix = new DistanceMatrix(YOUR_API_KEY_HERE);

$distance = $distanceMatrix->distance([
    'origins' => 'Prof. van der Waalsstraat 2 Alkmaar', 
    'destinations' => 'Paleis Noordeinde Den Haag'
]);

if ($distance > 0) {
	echo round($distance / 1000, 2) . "km"; // 84.5km
}
```

## More control
```php
use MartijnOud\DistanceMatrix\DistanceMatrix;

$distanceMatrix = new DistanceMatrix(YOUR_API_KEY_HERE);

$distance = $distanceMatrix->distance([
	'origins' => 'Leith', 
	'destinations' => 'Arques',
	'mode' => 'walking',
	'language' => 'en-GB',
]);

if ($distance > 0) {
	echo "I would walk " . $distance * 0.00062137119 . " miles"; // I would walk 493.88322020532 miles
}
````

## Generating a map
An API key is not required for this. If you do supply a key make sure this key has premission to use the Static Map API.
```php
use MartijnOud\DistanceMatrix\DistanceMatrix;

$distanceMatrix = new DistanceMatrix();

$image = $distanceMatrix->map([
	'origins' => 'Prof. van der Waalsstraat 2 Alkmaar', // required
	'destinations' => 'Amsterdam', // required
	'size' => '728x200'
]);

if ($image) {
	echo '<img src="'.$image.'" />';
}
```
![google-static-map](https://cloud.githubusercontent.com/assets/1292436/8251065/aba708ce-1679-11e5-8f26-95f8627fcb63.png)



## Todo

Ideas for future versions.

- [ ] Better error handling, checking rate limit, etc
- [x] Show a map with a line plotted between two points
