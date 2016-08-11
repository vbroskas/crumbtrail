<?php
namespace Edu\Cnm\CrumbTrail\Test;
require_once("/etc/apache2/capstone-mysql/encrypted-config.php")			// TODO Need this?

use Edu\Cnm\Mmalvar13\CrumbTrail\{Company, Profile};						// TODO Check this path.

// TODO Check the "invalid key" thing, from the CrumbTrailTest.php file.

// grab the project test parameters
require_once("CrumbTrailTest.php");

// grab the class under scrutiny
require_once(dirname(__DIR__) . "/public_html/php/classes/autoload.php");

/**
 * Full PHPUnit test for the Company class
 *
 * This is a complete PHPUnit test of the Company class.
 * It is complete because *ALL* mySQL/PDO enabled methods
 * are tested for both invalid and valid inputs.
 *
 * @see Company
 * @author Kevin Lee Kirk
 *
 **/

class CompanyTest extends CrumbTrailTest {

	// Set the protected parameter values.

	/**
	 * name of the Company
	 * @var string $VALID_COMPANYNAME
	 **/
	protected $VALID_COMPANYNAME = "Bob's hamburgers";
	/**
	 * name of the updated Company
	 * @var string $VALID_COMPANYNAME2
	 **/
	protected $VALID_COMPANYNAME2 = "Joe's tacos";

	/**
	 * email of the Company
	 * @var string $VALID_COMPANYEMAIL
	 **/
	protected $VALID_COMPANYEMAIL = "bob@bobs.com";
	/**
	 * email of the updated Company
	 * @var string $VALID_COMPANYEMAIL2
	 **/
	protected $VALID_COMPANYEMAIL2 = "bobnew@bobs.com";

	/**
	 * permit of the Company
	 * @var string $VALID_COMPANYPERMIT
	 **/
	protected $VALID_COMPANYPERMIT = "12345";
	/**
	 * permit of the updated Company
	 * @var string $VALID_COMPANYPERMIT2
	 **/
	protected $VALID_COMPANYPERMIT2 = "67890";

	/**
	 * license of the Company
	 * @var string $VALID_COMPANYLICENSE
	 **/
	protected $VALID_COMPANYLICENSE = "2468";
	/**
	 * license of the updated Company
	 * @var string $VALID_COMPANYLICENSE2
	 **/
	protected $VALID_COMPANYLICENSE2 = "1012";

	/**
	 * attn of the Company
	 * @var string $VALID_COMPANYATTN
	 **/
	protected $VALID_COMPANYATTN = "Bob Smith";
	/**
	 * attn of the updated Company
	 * @var string $VALID_COMPANYATTN2
	 **/
	protected $VALID_COMPANYATTN2 = "Bob New Smith";

	/**
	 * street1 of the Company
	 * @var string $VALID_COMPANYSTREET1
	 **/
	protected $VALID_COMPANYSTREET1 = "123 Old Street";
	/**
	 * street1 of the updated Company
	 * @var string $VALID_COMPANYSTREET12
	 **/
	protected $VALID_COMPANYSTREET12 = "123 New Street";

	/**
	 * street2 of the Company
	 * @var string $VALID_COMPANYSTREET2
	 **/
	protected $VALID_COMPANYSTREET2 = "Appt. 1A";
	/**
	 * street2 of the updated Company
	 * @var string $VALID_COMPANYSTREET22
	 **/
	protected $VALID_COMPANYSTREET22 = "Appt. 2B";

	/**
	 * city of the Company
	 * @var string $VALID_COMPANYCITY
	 **/
	protected $VALID_COMPANYCITY = "Springfield";
	/**
	 * city of the updated Company
	 * @var string $VALID_COMPANYCITY2
	 **/
	protected $VALID_COMPANYCITY2 = "New Springfield";

	/**
	 * state of the Company
	 * @var string $VALID_COMPANYSTATE
	 **/
	protected $VALID_COMPANYSTATE = "NM";
	/**
	 * state of the updated Company
	 * @var string $VALID_COMPANYSTATE2
	 **/
	protected $VALID_COMPANYSTATE2 = "CO";

	/**
	 * zip of the Company
	 * @var int $VALID_COMPANYZIP
	 **/
	protected $VALID_COMPANYZIP = "97405";
	/**
	 * zip of the updated Company
	 * @var int $VALID_COMPANYZIP2
	 **/
	protected $VALID_COMPANYZIP2 = "87048";

	/**
	 * description of the Company
	 * @var string $VALID_COMPANYDESCRIPTION
	 **/
	protected $VALID_COMPANYDESCRIPTION = "This is a description of a food truck company";
	/**
	 * description of the updated Company
	 * @var string $VALID_COMPANYDESCRIPTION2
	 **/
	protected $VALID_COMPANYDESCRIPTION2 = "This is a new description of a food truck company";

	/**
	 * menu text of the Company
	 * @var string $VALID_COMPANYMENUTEXT
	 **/
	protected $VALID_COMPANYMENUTEXT = "Tacos, burritos, beer";
	/**
	 * menu text of the updated Company
	 * @var string $VALID_COMPANYMENUTEXT2
	 **/
	protected $VALID_COMPANYMENUTEXT2 = "Ham, cheese, wine";

	/**
	 * activation token of the Company
	 * @var string $VALID_COMPANYACTIVATIONTOKEN
	 **/
	protected $VALID_COMPANYACTIVATIONTOKEN = "12345678";
	/**
	 * activation token of the updated Company
	 * @var string $VALID_COMPANYACTIVATION2
	 **/
	protected $VALID_COMPANYACTIVATIONTOKEN2 = "23456789";

	/**
	 * approved of the Company
	 * @var int $VALID_COMPANYAPPROVED
	 **/
	protected $VALID_COMPANYAPPROVED = "0";
	/**
	 * approved of the updated Company
	 * @var int $VALID_COMPANYAPPROVED2
	 **/
	protected $VALID_COMPANYAPPROVED2 = "1";

	/**
	 * The Profile of the person who created this account = companyAccountCreator,
	 * which is the foreign key.
	 * @var Profile profile
	 */
	protected $profile = null;


	/**
	 * Create dependent objects before running each test.
	 *
	 * Profile is a foreign key in Company,
	 * so we need a fake Profile to use in the test of Company.
	 * The companyAccountCreatorId is the profileId of the person who created this account.
	 **/
	public final function setUp() {
		// run the default setUp() method first
		parent::setUp();

		// create and insert a Profile to own the test Company.   // TODO Fix the long integers.
		$this->profile = new Profile(null, "Bob Smith", "test@phpunit.de", "+12125551212", "0000000000000000000000000000000000000000000000000000000000004444", "00000000000000000000000000000022", "O", null, null);
		$this->profile->insert($this->getPDO());
	}


	/**
	 * Test inserting a valid Company into the mySQL database,
	 * then check if the data in the database is equal to the
	 * data that you put into the database.
	 **/
	public function testInsertValidCompany() {
		// Count the number of rows and save it for later.
		$numRows = $this->getConnection()->getRowCount("company");

		// Create a new Company and insert to into mySQL.
		$company = new Company(null, $this->VALID_COMPANYNAME, $this->VALID_COMPANYEMAIL, $this->VALID_COMPANYPERMIT, $this->VALID_COMPANYLICENSE, $this->VALID_COMPANYATTN, $this->VALID_COMPANYSTREET1, $this->VALID_COMPANYSTREET2, $this->VALID_COMPANYCITY, $this->VALID_COMPANYSTATE, $this->VALID_COMPANYZIP, $this->VALID_COMPANYDESCRIPTION, $this->VALID_COMPANYMENUTEXT, $this->VALID_COMPANYACTIVATIONTOKEN, $this->VALID_COMPANYAPPROVED, $this->profile->getProfileId());

		$company->insert($this->getPDO());

		// Grab the data from mySQL and enforce the fields match our expectations
		$pdoCompany = Company::getCompanyByCompanyId($this->getPDO(), $company->getCompanyId());

		$this->assertEquals($numRows + 1, $this->getConnection()->getRowCount("company"));

		$this->assertEquals($pdoCompany->getCompanyId(), $this->company->getCompanyId());
		$this->assertEquals($pdoCompany->getCompanyName(), $this->company->getCompanyName());
		$this->assertEquals($pdoCompany->getCompanyEmail(), $this->company->getCompanyEmail());
		$this->assertEquals($pdoCompany->getCompanyPermit(), $this->company->getCompanyPermit());
		$this->assertEquals($pdoCompany->getCompanyLicense(), $this->company->getCompanyLicense());
		$this->assertEquals($pdoCompany->getCompanyAttn(), $this->company->getCompanyAttn());
		$this->assertEquals($pdoCompany->getCompanyStreet1(), $this->company->getCompanyStreet1());
		$this->assertEquals($pdoCompany->getCompanyStreet2(), $this->company->getCompanyStreet2());
		$this->assertEquals($pdoCompany->getCompanyCity(), $this->company->getCompanyCity());
		$this->assertEquals($pdoCompany->getCompanyState(), $this->company->getCompanyState());
		$this->assertEquals($pdoCompany->getCompanyZip(), $this->company->getCompanyZip());
		$this->assertEquals($pdoCompany->getCompanyDescription(), $this->company->getCompanyDescription());
		$this->assertEquals($pdoCompany->getCompanyMenuText(), $this->company->getCompanyMenuText());
		$this->assertEquals($pdoCompany->getCompanyActivationToken(), $this->company->getCompanyActivationToken());
		$this->assertEquals($pdoCompany->getCompanyApproved(), $this->company->getCompanyApproved());
		$this->assertEquals($pdoCompany->getProfileId(), $this->profile->getProfileId());
	}

	/**
	 * Test inserting a Company that already exists.
	 * Create a Company with a non-null company id and watch it fail.
	 * @expectedException PDOException
	 **/
	public function testInsertInvalidCompany() {
		//   TODO Do we need a $this->profile->getProfileId() ???
		$company = new Company(CrumbTrailTest::INVALID_KEY, $this->VALID_COMPANYNAME, $this->VALID_COMPANYEMAIL, $this->VALID_COMPANYPERMIT, $this->VALID_COMPANYLICENSE, $this->VALID_COMPANYATTN, $this->VALID_COMPANYSTREET1, $this->VALID_COMPANYSTREET2, $this->VALID_COMPANYCITY, $this->VALID_COMPANYSTATE, $this->VALID_COMPANYZIP, $this->VALID_COMPANYDESCRIPTION, $this->VALID_COMPANYMENUTEXT, $this->VALID_COMPANYACTIVATIONTOKEN, $this->VALID_COMPANYAPPROVED, $this->profile->getProfileId());

		$company>insert($this->getPDO());
	}


	/**
	 * Test inserting a Company, editing it, and then updating it.
	 **/
	public function testUpdateValidCompany() {
		// count the number of rows and save it for later
		$numRows = $this->getConnection()->getRowCount("company");

		// Create a new Company and insert to into mySQL.
		$company = new Company(null, $this->VALID_COMPANYNAME, $this->VALID_COMPANYEMAIL, $this->VALID_COMPANYPERMIT, $this->VALID_COMPANYLICENSE, $this->VALID_COMPANYATTN, $this->VALID_COMPANYSTREET1, $this->VALID_COMPANYSTREET2, $this->VALID_COMPANYCITY, $this->VALID_COMPANYSTATE, $this->VALID_COMPANYZIP, $this->VALID_COMPANYDESCRIPTION, $this->VALID_COMPANYMENUTEXT, $this->VALID_COMPANYACTIVATIONTOKEN, $this->VALID_COMPANYAPPROVED, $this->profile->getProfileId());

		$company->insert($this->getPDO());

		// Edit the Company and update it in mySQL.
		$company->setCompanyName($this->VALID_COMPANYNAME2);
		$company->setCompanyEmail($this->VALID_COMPANYEMAIL2);
		$company->setCompanyPermit($this->VALID_COMPANYPERMIT2);
		$company->setCompanyLicense($this->VALID_COMPANYLICENSE2);
		$company->setCompanyAttn($this->VALID_COMPANYATTN2);
		$company->setCompanyStreet1($this->VALID_COMPANYSTREET12);
		$company->setCompanyStreet2($this->VALID_COMPANYSTREET22);
		$company->setCompanyCity($this->VALID_COMPANYCITY2);
		$company->setCompanyState($this->VALID_COMPANYSTATE2);
		$company->setCompanyZip($this->VALID_COMPANYZIP2);
		$company->setCompanyDescription($this->VALID_COMPANYDESCRIPTION2);
		$company->setCompanyMenuText($this->VALID_COMPANYMENUTEXT2);
		$company->setCompanyActivationToken($this->VALID_COMPANYACTIVATIONTOKEN2);
		$company->setCompanyApproved($this->VALID_COMPANYAPPROVED2);
		$this->assertEquals($pdoCompany->getProfileId(), $this->profile->getProfileId());

		$company->update($this->getPDO());

		// Grab the data from mySQL and check that the fields match our (updated) expectations.
		$pdoCompany = Company::getCompanyByCompanyId($this->getPDO(), $company->getCompanyId());

		$this->assertEquals($numRows + 1, $this->getConnection()->getRowCount("$company"));

		// TODO Need?  $this->assertEquals($pdoCompany->getProfileId(), $this->profile->getProfileId());
		$this->assertEquals($pdoCompany->getCompanyName(), $this->VALID_COMPANYNAME2);

		$this->assertEquals($pdoCompany->getCompanyEmail(), $this->VALID_COMPANYEMAIL2());
		$this->assertEquals($pdoCompany->getCompanyPermit(), $this->VALID_COMPANYPERMIT2());
		$this->assertEquals($pdoCompany->getCompanyLicense(), $this->VALID_COMPANYLICENSE2());
		$this->assertEquals($pdoCompany->getCompanyAttn(), $this->VALID_COMPANYATTN2());
		$this->assertEquals($pdoCompany->getCompanyStreet1(), $this->VALID_COMPANYSTREET12());
		$this->assertEquals($pdoCompany->getCompanyStreet2(), $this->VALID_COMPANYSTREET22());
		$this->assertEquals($pdoCompany->getCompanyCity(), $this->VALID_COMPANYCITY2());
		$this->assertEquals($pdoCompany->getCompanyState(), $this->VALID_COMPANYSTATE2());
		$this->assertEquals($pdoCompany->getCompanyZip(), $this->VALID_COMPANYZIP2());
		$this->assertEquals($pdoCompany->getCompanyDescription(), $this->VALID_COMPANYDESCRIPTION2());
		$this->assertEquals($pdoCompany->getCompanyMenuText(), $this->VALID_COMPANYMENUTEXT2());
		$this->assertEquals($pdoCompany->getCompanyActivationToken(), $this->VALID_COMPANYACTIVATIONTOKEN2());
		$this->assertEquals($pdoCompany->getCompanyApproved(), $this->VALID_COMPANYAPPROVED2());
		$this->assertEquals($pdoCompany->getProfileId(), $this->profile->getProfileId());
	}

	/**
	 * Test updating a Company that does not exist.
	 *
	 * @expectedException PDOException
	 **/
	public function testUpdateInvalidCompany() {
		// Create a Company, try to update it (without actually updating it), and watch it fail.
		$company = new Company(null, $this->VALID_COMPANYNAME, $this->VALID_COMPANYEMAIL, $this->VALID_COMPANYPERMIT, $this->VALID_COMPANYLICENSE, $this->VALID_COMPANYATTN, $this->VALID_COMPANYSTREET1, $this->VALID_COMPANYSTREET2, $this->VALID_COMPANYCITY, $this->VALID_COMPANYSTATE, $this->VALID_COMPANYZIP, $this->VALID_COMPANYDESCRIPTION, $this->VALID_COMPANYMENUTEXT, $this->VALID_COMPANYACTIVATIONTOKEN, $this->VALID_COMPANYAPPROVED, $this->profile->getProfileId());

		$company->update($this->getPDO());
	}

	/**
	 * Test creating a Company and then deleting it
	 **/
	public function testDeleteValidCompany() {
		// Count the number of rows and save it for later.
		$numRows = $this->getConnection()->getRowCount("company");

		// Create a new Company and insert to into mySQL.
		$tweet = new Company(null, $this->VALID_COMPANYNAME, $this->VALID_COMPANYEMAIL, $this->VALID_COMPANYPERMIT, $this->VALID_COMPANYLICENSE, $this->VALID_COMPANYATTN, $this->VALID_COMPANYSTREET1, $this->VALID_COMPANYSTREET2, $this->VALID_COMPANYCITY, $this->VALID_COMPANYSTATE, $this->VALID_COMPANYZIP, $this->VALID_COMPANYDESCRIPTION, $this->VALID_COMPANYMENUTEXT, $this->VALID_COMPANYACTIVATIONTOKEN, $this->VALID_COMPANYAPPROVED, $this->profile->getProfileId());

		$company->insert($this->getPDO());

		// Delete the Company from mySQL.
		$this->assertEquals($numRows + 1, $this->getConnection()->getRowCount("company"));
		$tweet->delete($this->getPDO());

		// Get the data from mySQL and enforce the Company does not exist.
		$pdoTweet = Company::getCompanyByCompanyId($this->getPDO(), $company->getCompanyId());
		$this->assertNull($pdoCompany);
		$this->assertEquals($numRows, $this->getConnection()->getRowCount("company"));
	}


	/**
	 * Test deleting a Company that does not exist.
	 *
	 * @expectedException PDOException
	 **/
	public function testDeleteInvalidCompany() {
		// Create a Company, and try to delete it, without actually inserting it.
		$tweet = new Company(null, $this->profile->getProfileId(), $this->VALID_TWEETCONTENT);
		$tweet->delete($this->getPDO());
	}


	/**
	 * Test getting a Company by company name
	 **/
	public function testGetValidCompanyByCompanyName() {
		// Count the number of rows and save it for later.
		$numRows = $this->getConnection()->getRowCount("company");

		// Create a new Company and insert to into mySQL.
		$tweet = new Company(null, $this->profile->getProfileId(), $this->VALID_TWEETCONTENT);
		$tweet->insert($this->getPDO());

		// Grab the data from mySQL and enforce the fields match our expectations.
		$results = Company::getCompanyByCompanyName($this->getPDO(), $company->getCompanyName());
		$this->assertEquals($numRows + 1, $this->getConnection()->getRowCount("company"));
		$this->assertCount(1, $results);
		$this->assertContainsOnlyInstancesOf("Edu\\Cnm\\MMalvar13\\CrumbTrail\\Company", $results);

		// Grab the result from the array and validate it.
		$pdoCompany = $results[0];
		$this->assertEquals($pdoCompany->getProfileId(), $this->profile->getProfileId());
		$this->assertEquals($pdoCompany->getCompanyName(), $this->VALID_COMPANYNAME);
	}

	/**
	 * Test getting a Company by content that does not exist
	 **/
	public function testGetInvalidCompanyByCompanyName() {
		// Grab a company by searching for a company name that does not exist.
		$tweet = Company::getCompanyByCompanyName($this->getPDO(), "This is not a company name");
		$this->assertCount(0, $company);
	}

	/**
	 * Test getting all Companies.
	 **/
	public function testGetAllValidCompany() {
		// Count the number of rows and save it for later.
		$numRows = $this->getConnection()->getRowCount("company");

		// Create a new Company and insert to into mySQL.
		$company = new Company(null, $this->VALID_COMPANYNAME, $this->VALID_COMPANYEMAIL, $this->VALID_COMPANYPERMIT, $this->VALID_COMPANYLICENSE, $this->VALID_COMPANYATTN, $this->VALID_COMPANYSTREET1, $this->VALID_COMPANYSTREET2, $this->VALID_COMPANYCITY, $this->VALID_COMPANYSTATE, $this->VALID_COMPANYZIP, $this->VALID_COMPANYDESCRIPTION, $this->VALID_COMPANYMENUTEXT, $this->VALID_COMPANYACTIVATIONTOKEN, $this->VALID_COMPANYAPPROVED, $this->profile->getProfileId());
		$company->insert($this->getPDO());

		// Get the data from mySQL, and check that fields match our expectations.
		$results = Company::getAllCompanys($this->getPDO());
		$this->assertEquals($numRows + 1, $this->getConnection()->getRowCount("company"));
		$this->assertCount(1, $results);

		// TODO What is going on in the next line?
		$this->assertContainsOnlyInstancesOf("Edu\\Cnm\\Mmalvar13\\CrumbTrail\\Company", $results);

		// Get the result from the array, and validate it.
		$pdoCompany= $results[0];
		$this->assertEquals($pdoCompany->getCompanyEmail(), $this->VALID_COMPANYEMAIL());
		$this->assertEquals($pdoCompany->getCompanyPermit(), $this->VALID_COMPANYPERMIT());
		$this->assertEquals($pdoCompany->getCompanyLicense(), $this->VALID_COMPANYLICENSE());
		$this->assertEquals($pdoCompany->getCompanyAttn(), $this->VALID_COMPANYATTN());
		$this->assertEquals($pdoCompany->getCompanyStreet1(), $this->VALID_COMPANYSTREET1());
		$this->assertEquals($pdoCompany->getCompanyStreet2(), $this->VALID_COMPANYSTREET2());
		$this->assertEquals($pdoCompany->getCompanyCity(), $this->VALID_COMPANYCITY());
		$this->assertEquals($pdoCompany->getCompanyState(), $this->VALID_COMPANYSTATE());
		$this->assertEquals($pdoCompany->getCompanyZip(), $this->VALID_COMPANYZIP());
		$this->assertEquals($pdoCompany->getCompanyDescription(), $this->VALID_COMPANYDESCRIPTION());
		$this->assertEquals($pdoCompany->getCompanyMenuText(), $this->VALID_COMPANYMENUTEXT());
		$this->assertEquals($pdoCompany->getCompanyActivationToken(), $this->VALID_COMPANYACTIVATIONTOKEN());
		$this->assertEquals($pdoCompany->getCompanyApproved(), $this->VALID_COMPANYAPPROVED());
		$this->assertEquals($pdoCompany->getProfileId(), $this->profile->getProfileId());
	}
}