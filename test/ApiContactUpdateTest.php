<?php

namespace ESoft\SlimSample;

class ApiContactUpdateTest extends ApiBaseTest
{
    /**
     * test status code is 200, and data is updated when correct data is submitted
     * @return void
     */
    public function testCreateContactReturnsStatusCode200WithCorrectData()
    {
        $contactData = [
            'first_name' => 'Daffy',
            'last_name' => 'Duck',
            'title' => "Duck A L'Orange",
            'email' => 'dduck@acme.com',
            'addresses' => $this->contact->addresses->toArray(),
            'phoneNumbers' =>[]
        ];
        foreach ($this->contact->phoneNumbers->toArray() as $phone) {
            $phone['number'] ='555.558.5321';
            $contactData['phoneNumbers'][] =$phone;
        }
        $response = $this->put('/contacts/' . $this->contact->id, $contactData);
        $result = (string) $response->getBody();
        $this->assertSame($response->getStatusCode(), 200);
        $this->assertContains('Daffy', $result);
        $this->assertContains('558', $result);
    }

    /**
     * test returns 400 when submitted with invalid email
     * @return void
     */
    public function testUpdateContactReturnsStatusCode400WithBadEmail()
    {
        $contactData = [
            'first_name' => 'Foghorn',
            'last_name' => 'Leghorn',
            'title' => '',
            'email' => 'fleghornacme.com',
        ];
        $response = $this->put('/contacts/' . $this->contact->id, $contactData);
        $result = (string) $response->getBody();
        $this->assertSame($response->getStatusCode(), 400);
        $this->assertContains('must be valid email', $result);
    }

    /**
     * test returns 400 when first name is missing
     * @return void
     */
    public function testUpdateContactReturnsStatusCode400WithMissingFirstName()
    {
        $contactData = [
            'last_name' => 'Pig',
            'title' => '',
            'email' => 'ppig@acme.com',
        ];
        $response = $this->put('/contacts/' . $this->contact->id, $contactData);
        $result = (string) $response->getBody();
        $this->assertSame($response->getStatusCode(), 400);
        $this->assertContains('must not be empty', $result);
    }

    /**
     * test returns 400 when last name is missing
     * @return void
     */
    public function testUpdateContactReturnsStatusCode400WithMissingLastName()
    {
        $contactData = [
            'first_name' => 'Pepe',
            'title' => '',
            'email' => 'plepew@acme.com',
        ];
        $response = $this->put('/contacts/' . $this->contact->id, $contactData);
        $result = (string) $response->getBody();
        $this->assertSame($response->getStatusCode(), 400);
        $this->assertContains('must not be empty', $result);
    }
}
