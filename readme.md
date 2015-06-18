# DistanceMatrix PHP API Wrapper

Very simple API Wrapper for Google's DistanceMatrix API. Enter two addresses and the class returns the distance between them in meter.


## Basic usage
Calculate the distance in meters between the [Inktweb.nl office](https://www.inktweb.nl/) and Paleis Noordeinde in the Hague.
````PHP
<?php
require_once('DistanceMatrix.php');

$DistanceMatrix = new MartijnOud\DistanceMatrix(YOUR_API_KEY_HERE);
$distance = $DistanceMatrix->distance(array('origins' => 'Prof. van der Waalsstraat 2 Alkmaar', 'destinations' => 'Paleis Noordeinde Den Haag'));
if ($distance > 0) {
	echo round($distance / 1000, 2) . "km"; // 84.5km
}
````

## More control
````PHP
<?php
require_once('DistanceMatrix.php');

$DistanceMatrix = new MartijnOud\DistanceMatrix(YOUR_API_KEY_HERE);
$distance = $DistanceMatrix->distance(array(
	'origins' => 'Leith', 
	'destinations' => 'Arques',
	'mode' => 'walking',
	'language' => 'en-GB',
	));
if ($distance > 0) {
	echo "I would walk " . $distance * 0.00062137119 . " miles"; // I would walk 493.88322020532 miles
}
````



## Todo

Ideas for future versions.

- [ ] Better error handeling, checking rate limit, etc
- [ ] Show a map with a line plotted between two points
