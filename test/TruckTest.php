<?php
namespace Edu\Cnm\CrumbTrail\Test;

use Edu\Cnm\CrumbTrail\{Profile, Company, Truck
};

//grab the project test parameters
require_once("CrumbTrailTest.php");

//grab the class under scrutiny
require_once(dirname(__DIR__) . "/public_html/php/classes/autoload.php");

/**
 * Unit test for the truck class
 *
 * All mySQL/PDO enabled methods tested for valid and invalid inputs
 *
 * @see Truck
 * @author Victoria Chacon <victoriousdesignco@gmail.com>
 **/



class TruckTest extends CrumbTrailTest {
	//setting up made up variables to test
	/**
	 *Company that the Truck belongs to; this is a foreign key relationship
	 * @var Company company
	 **/
	protected $company = null;
	/**
	 *Company that the Truck is transferred to; this is a foreign key relationship
	 * @var Company company2
	 **/
	protected $company2 = null;

	protected $profile = null;
	protected $profile2 = null;


	/**
	 * create dependent objects before running each test
	 **/
	//run the default setUp() method first (creating a face company to house the test truck)
	public final function setUp() {
		//run the default setUp() method first
		parent::setUp();

		//create a insert for a dummy company so we have a foreign key to profile
		//THIS WAS 100% MONICA'S IDEA. LOREN IS JUST A KEYBOARD AUTOMATON
		$password = "abc123";
		$salt = bin2hex(random_bytes(16));
		$hash = hash_pbkdf2("sha512", $password, $salt, 262144);

		// Put dummy values into the Profile attributes.

		//------------Profile 1--------------------------------------------------
		$this->profile = new Profile(null, "Bob", "test@phpunit.de", "12125551212", "0000000000000000000000000000000000000000000000000000000000004444", "00000000000000000000000000000022", "o", $hash, $salt);
		// Insert the dummy profile object into the database.
		$this->profile->insert($this->getPDO());
		$pdoProfile = Profile::getProfileByProfileId($this->getPDO(), $this->profile->getProfileId());

		//--------------Profile 2-------------------------------------------------
		$this->profile2 = new Profile(null, "john", "john@gmail.com", "12125555567", "0000000000000000000000000000000000000000000000000000000000005555", "00000000000000000000000000000088", "e", $hash, $salt);
		// Insert the dummy profile object into the database.
		$this->profile2->insert($this->getPDO());
		$pdoProfile2 = Profile::getProfileByProfileId($this->getPDO(), $this->profile2->getProfileId());

		//create and insert a company to own the test truck
		//---------------------company1------------------------------------------------
		$this->company = new Company(null, $pdoProfile->getProfileId(), "Terry's Tacos", "terrytacos@tacos.com", "5052345678", "12345", "2345", "attn: MR Taco", "345 Taco Street", "Taco Street 2", "Albuquerque", "NM", "87654", "We are a Taco truck description", "Tacos, Tortillas, Burritos", "84848409878765432123456789099999", 1);
		$this->company->insert($this->getPDO());

		//--------------------------company2-----------------------------------------
		//create and insert a second company to buy the test truck (a truck moving to another company)
		$this->company2 = new Company(null, $pdoProfile2->getProfileId(), "Truckina's Crepes", "truckina@trucks.com", "5052345666", "45678", "4567", "attn: MRS Crepe", "456 Crepe Street", "CrepeStreet2", "Albuquerque", "NM", "45678", "We sell crepes", "crepes, ice cream, cakes", "34343409876543212345678998787654", 0);
		$this->company2->insert($this->getPDO());
	}


	/**
	 * insert valid truck to verify that the actual mySQL data matches
	 **/
	public function testInsertValidTruck() {
		$numRows = $this->getConnection()->getRowCount("truck");

		//create new Truck and insert it into mySQL
		$truck = new Truck(null, $this->company->getCompanyId());
		$truck->insert($this->getPDO());

		//grab the data from mySQL and enforce the fields to match our expectations
		$pdoTruck = Truck::getTruckByTruckId($this->getPDO(), $truck->getTruckId());
		$this->assertEquals($numRows + 1, $this->getConnection()->getRowCount("truck"));
		$this->assertEquals($pdoTruck->getTruckCompanyId(), $this->company->getCompanyId());
	}

	/**
	 *test inserting a truck that already exists
	 *
	 * @expectedException \PDOException
	 **/

	public function testInsertInvalidTruck() {
		//create a truck with a non null truck id. It will fail.
		$truck = new Truck(CrumbTrailTest::INVALID_KEY, $this->company->getCompanyId());
		$truck->insert($this->getPDO());
	}

	/**
	 * test inserting an Truck, editing it, and then updating it
	 **/
	public function testUpdateValidTruck() {
		//count the number of rows and save it for later
		$numRows = $this->getConnection()->getRowCount("truck");

		//create a new Truck and insert into mySQL
		$truck = new Truck(null, $this->company->getCompanyId());
		$truck->insert($this->getPDO());

		//edit the Truck and update it in mySQL
		//MAYBE???
		$truck->setTruckCompanyId($this->company2->getCompanyId());
		$truck->update($this->getPDO());
		//grab the data from mySQL and enforce the fields match our expectations

		$pdoTruck = Truck::getTruckByTruckId($this->getPDO(), $truck->getTruckId());

		$this->assertEquals($numRows + 1, $this->getConnection()->getRowCount("truck"));
		$this->assertEquals($pdoTruck->getTruckCompanyId(), $this->company2->getCompanyId()); //change back to company 2
	}

	/**
	 * test updating an truck that does not exist
	 *
	 * @expectedException \PDOException
	 **/
	public function testUpdateInvalidTruck() {
		//create a Truck, try to update it without actually updating it, watch it fail.
		$truck = new Truck(null, $this->company->getCompanyId());
		$truck->update($this->getPDO());
	}

	/**
	 * test creating a truck and deleting it
	 **/
	public function testDeleteValidTruck() {
		//count the number of rows and save it for later
		$numRows = $this->getConnection()->getRowCount("truck");

		//create new Truck and insert it into mySQL
		$truck = new Truck(null, $this->company->getCompanyId());
		$truck->insert($this->getPDO());

		//delete the truck from mySQL
		$this->assertEquals($numRows + 1, $this->getConnection()->getRowCount("truck"));
		$truck->delete($this->getPDO());

		//grab the data from mySQL and enforce that the Truck does not exist/
		$pdoTruck = Truck::getTruckByTruckId($this->getPDO(), $truck->getTruckId());
		$this->assertNull($pdoTruck);
		$this->assertEquals($numRows, $this->getConnection()->getRowCount("truck"));
	}

	/**
	 * test deleting and Truck that does not exist
	 *
	 * @expectedException \PDOException
	 **/
	public function testDeleteInvalidTruck() {
		//create a Truck and try to delete without actually inserting it
		$truck = new Truck(null, $this->company->getCompanyId());
		$truck->delete($this->getPDO());
	}

	/**
	 * Test getting trucks by truck company Id
	 *
	 * @expectedException \PDOException
	 **/
	public function testGetTruckByTruckCompanyId() {

		//count the number of rows and save it for later
		$numRows = $this->getConnection()->getRowCount("truck");

		// Create a new Truck and insert it into mySQL
		$truck = new Truck(null, $this->company->getCompanyId());
		$truck->insert($this->getPDO());

		//Grab the data from mySQL and check that the fields match our expectations.
		$results = Truck::getTruckByTruckCompanyId($this->getPDO(),$this->company->getCompanyId());

		$this->assertEquals($numRows, $this->getConnection()->getRowCount("truck"));
		$this->assertCount(1, $results);
		$this->assertContainsOnlyInstancesOf("Edu\\Cnm\\CrumbTrail\\Image", $results);
		//grab the results from the array an validate it
		$pdoTruck = $results[0];
		$this->assertEquals($pdoTruck->getTruckCompanyId(), $this->company->getCompanyId());
	}

	/**
	 * test grabbing all trucks
	 **/
	public function testGetAllValidTrucks() {
		//count the number of rows and save it for later
		$numRows = $this->getConnection()->getRowCount("truck");

		//create a new Image and insert it into mySQL
		$truck = new Truck(null, $this->company->getCompanyId());
		$truck->insert($this->getPDO());
		//grab the data from mySQL and enforce the fields match our expectations
		$results = Truck::getAllTrucks($this->getPDO());
		$this->assertEquals($numRows + 1, $this->getConnection()->getRowCount("truck"));
		$this->assertCount(1, $results);
		$this->assertContainsOnlyInstancesOf("Edu\\Cnm\\CrumbTrail\\Truck", $results);

		//grab the result from the array and validate it
		$pdoTruck = $results[0];
		$this->assertEquals($pdoTruck->getTruckCompanyId(), $this->company->getCompanyId());
		$this->assertEquals($numRows + 1, $this->getConnection()->getRowCount("truck"));
	}
}
	//This is the end of the Truck unit test, trial four//