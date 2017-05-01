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

    public function getContact($request, $response, $args)
    {
        $result = Contact::with('phoneNumbers', 'addresses')->find($args['id']);
        if (!$contact) {
            return $response
            ->withJson(['message'=>'Contact with id ' . $args['id'] . ' not found'])
            ->withStatus(404);
        }
        return $response->withJson($result->toArray());
    }

    public function deleteContact($request, $response, $args)
    {
        $contact = Contact::find($args['id']);
        if (!$contact) {
            return $response
            ->withJson(['message'=>'Contact with id ' . $args['id'] . ' not found'])
            ->withStatus(404);
        }
        $contact->delete();
        return $response->withStatus(204);
    }
}
