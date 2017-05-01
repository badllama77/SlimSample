<?php
namespace ESoft\SlimSample;

class ApiContactCreateTest extends ApiBaseTest
{
    /**
     * test returns 201 when valid data is submitted
     * @return [type] [description]
     */
    public function testCreateContactReturnsStatusCode201WithCorrectData()
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
        $response = $this->post('/contacts', $contactData);
        $result = (string) $response->getBody();
        $this->assertSame($response->getStatusCode(), 201);
        $this->assertContains('Yosemite', $result);
    }

    /**
     * test returns 201 when correct data is submitted without address or phone
     * @return void
     */
    public function testCreateContactReturnsStatusCode201WithCorrectDataWithoutAddressOrPhone()
    {
        $contactData = [
            'first_name' => 'Daffy',
            'last_name' => 'Duck',
            'title' => '',
            'email' => 'dduck@acme.com',
        ];
        $response = $this->post('/contacts', $contactData);
        $result = (string) $response->getBody();
        $this->assertSame($response->getStatusCode(), 201);
        $this->assertContains('Daffy', $result);
    }

    /**
     * test return 400 when email is invalid
     * @return void
     */
    public function testCreateContactReturnsStatusCode400WithBadEmail()
    {
        $contactData = [
            'first_name' => 'Foghorn',
            'last_name' => 'Leghorn',
            'title' => '',
            'email' => 'fleghornacme.com',
        ];
        $response = $this->post('/contacts', $contactData);
        $result = (string) $response->getBody();
        $this->assertSame($response->getStatusCode(), 400);
        $this->assertContains('must be valid email', $result);
    }

    /**
     * test returns 400 when first name is missing
     * @return void
     */
    public function testCreateContactReturnsStatusCode400WithMissingFirstName()
    {
        $contactData = [
            'last_name' => 'Pig',
            'title' => '',
            'email' => 'ppig@acme.com',
        ];
        $response = $this->post('/contacts', $contactData);
        $result = (string) $response->getBody();
        $this->assertSame($response->getStatusCode(), 400);
        $this->assertContains('must not be empty', $result);
    }

    /**
     * test returns 400 when last name is missing
     * @return void 
     */
    public function testCreateContactReturnsStatusCode400WithMissingLastName()
    {
        $contactData = [
            'first_name' => 'Pepe',
            'title' => '',
            'email' => 'plepew@acme.com',
        ];
        $response = $this->post('/contacts', $contactData);
        $result = (string) $response->getBody();
        $this->assertSame($response->getStatusCode(), 400);
        $this->assertContains('must not be empty', $result);
    }
}
