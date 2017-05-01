<?php
namespace ESoft\SlimSample;

use PHPUnit\Framework\TestCase;
use ESoft\SlimSample\ContactService;

class ContactSeviceTest extends TestCase
{
    protected $manager;
    protected $contact;
    protected $service;

    public function setUp()
    {
        $this->manager = new \Illuminate\Database\Capsule\Manager();
        $config =[
            'driver'=>'sqlite',
            'host'=>'127.0.0.1',
            'charset'=>'utf8',
            'collation'=>'utf8_unicode_ci',
            'database'=>':memory:'
        ];
        $this->manager->addConnection($config);
        $this->manager->setAsGlobal();
        $this->manager->bootEloquent();
        Schema::createTables();
        $this->contact = TestDataGenerator::populate();
        $this->service = new ContactService();
    }

    /**
     * test creates record when valid data is submitted
     * @return void
     */
    public function testBuildContactReturnContainsExpectedData()
    {
        $contactData = [
            'first_name' => 'Yosemite',
            'last_name' => 'Sam',
            'title' => 'Sheriff',
            'email' => 'ysam@acme.com',
            'addresses' => [
                [
                    'address_type' => 'home',
                    'city' => 'LooneyVille',
                    'state' => 'TX',
                    'zipcode' => '99593',
                    'street_line1' => '1313 Mockingbird lane',
                    'street_line2' => ''
                ]
            ],
            'phoneNumbers' => [
                ['phone_type' => 'home', 'number' => '555.555.1244'],
                ['phone_type' => 'work', 'number' => '555.555.1255'],
                ['phone_type' => 'cell', 'number' => '555.555.1266'],
            ]
        ];
        $result = $this->service->buildContact($contactData);
        $this->assertContains('Yosemite', $result->toArray());
    }

    /**
     * test throws when first name is missing
     * @expectedException ESoft\SlimSample\Exception\InvalidContactException
     * @expectedExceptionMessage empty
     * @return void
     */
    public function testValidateContactThrowsInvalidContactExceptionWithMissingFirstName()
    {
        $contactData = [
            'last_name' => 'Pig',
            'title' => '',
            'email' => 'ppig@acme.com',
        ];
        $this->service->validate($contactData);
    }

    /**
     * test throws exception when last name is missing
     * @expectedException ESoft\SlimSample\Exception\InvalidContactException
     * @expectedExceptionMessage empty
     * @return void
     */
    public function testValidateContactThrowsInvalidContactExceptionWithMissingLastName()
    {
        $contactData = [
            'first_name' => 'Pepe',
            'title' => '',
            'email' => 'plepew@acme.com',
        ];
        $this->service->validate($contactData);
    }

    public function testMarshallFunctionReturnsExpectedData()
    {
        $result = $this->service->marshallContact($this->contact);
        $this->assertInternalType('array', $result);
        $this->assertContains('Bunny', $result);
        $this->assertArrayHasKey('location', $result);
        $this->assertArrayHasKey('addresses', $result);
        $this->assertArrayHasKey('phone_numbers', $result);
    }

    public function testFindReturnsContactWithExistingId()
    {
        $contact = $this->service->findContact($this->contact->id);
        $this->contact->load('phoneNumbers', 'addresses');
        $existing = $this->contact->toArray();
        $retrieved = $contact->toArray();
        ksort($existing);
        ksort($retrieved);
        $this->assertSame($retrieved, $existing);
    }

    /**
     * test throws not found exception when id not found
     * @expectedException ESoft\SlimSample\Exception\ContactNotFoundException
     * @expectedExceptionMessage not found
     * @return void
     */
    public function testFindThrowsContactNotFoundExceptionWithFakeId()
    {
        $contact = $this->service->findContact(1234);
    }


}
