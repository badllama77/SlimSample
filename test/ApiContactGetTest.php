<?php
namespace ESoft\SlimSample;

use ESoft\SlimSample\Model\Contact;

class ApiContactGetTest extends ApiBaseTest
{
    /**
     * test get all returns data and 200
     * @return void
     */
    public function testGetAllContactWithIdReturnsStatusCode200()
    {
        $contact = Contact::first();
        $response = $this->get('/contacts');
        $result = (string) $response->getBody();
        $this->assertSame($response->getStatusCode(), 200);
        $this->assertContains('Bugs', $result);
    }
}
