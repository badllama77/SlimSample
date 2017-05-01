<?php
namespace ESoft\SlimSample;

use ESoft\SlimSample\Model\Contact;

class ApiContactDeleteTest extends ApiBaseTest
{
    /**
     * test delete with proper id returns 204
     * @return void
     */
    public function testDeleteContactWithIdReturnsStatusCode200()
    {
        $contact = Contact::first();
        $response = $this->delete('/contacts/'.$contact->id);
        $result = (string) $response->getBody();
        $this->assertSame($response->getStatusCode(), 204);
    }

    /**
     * test delete with unknown id returns 404
     * @return void 
     */
    public function testDeleteContactWithIdReturnsStatusCode404()
    {
        $response = $this->delete('/contact/' . '8758');
        $this->assertSame($response->getStatusCode(), 404);
    }
}
