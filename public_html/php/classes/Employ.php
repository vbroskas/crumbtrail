<?php
namespace Edu\Cnm\Crumbtrail; //idk

require_once("autoload.php");

/**
 * Welcome to the Employ class! Enjoy your stay!
 **/
class Employ{
	/**
	 * id of the profile that is employed by the company, this is a foreign key. Composite key with $employCompanyId.
	 * @var int|null $employProfileId
	 **/
	private $employProfileId;
	/**
	 * id of the Company that employed the profile, this is a foreign key. Composite key with $employProfileId.
	 * @var int|null $employCompanyId
	 **/
	private $employCompanyId;

/**
 * constructor for this EMPLOY??
 **/

/**
 * accessor method for employProfileId
 * @return int $employProfileId
 **/
public function getEmployProfileId(int $newEmployProfileId = null){ //null??
	return($this->employProfileId);
}
}