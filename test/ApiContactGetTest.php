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

    /**
     * test get with proper id returns 200
     * @return void
     */
    public function testGetContactWithIdReturnsStatusCode200()
    {
        $contact = Contact::first();
        $response = $this->get('/contacts/'.$contact->id);
        $result = (string) $response->getBody();
        $this->assertSame($response->getStatusCode(), 200);
        $this->assertContains('Bugs', $result);
    }

    /**
     * test get with unknown id returns 404
     * @return void
     */
    public function testGetContactWithIdReturnsStatusCode404()
    {
        $response = $this->get('/contact/' . '8758');
        $this->assertSame($response->getStatusCode(), 404);
    }
}
