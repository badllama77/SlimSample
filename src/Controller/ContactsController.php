<?php

namespace ESoft\SlimSample\Controller;

use ESoft\SlimSample\Model\Contact;

final class ContactsController
{
    public function getContacts($request, $response, $args)
    {
        $result = Contact::with('phoneNumbers', 'addresses')->get();
        return $response->withJson($result->toArray());
    }
}
