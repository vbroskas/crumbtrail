<?php
namespace Edu\Cnm\Crumbtrail; //probably wrong
require_once ("autoload.php"); //idk

/**
 * Class Point
 * @package Edu\Cnm\Crumbtrail
 * welcome to the point class! this is for things! emjoy your stay!
 **/
abstract class Point { //is this an abstract class?
	/**
	 * latitude for this point
	 * @var float $pointLatitude
	 **/
	private $pointLatitude;
	/**
	 * longitude for this  point
	 * @var float $pointLongitude
	 **/
	private $pointLongitude;

	/**
	 * Constructor for this Point
	 * @param int $newPointLatitude the latitude for this point
	 * @param int $newPointLongitude the longitude
	 **/
	public function __construct(float $newPointLatitude, float $newPointLongitude) {

	} //method should have a body or be

}