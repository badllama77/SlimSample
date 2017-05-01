<?php

namespace ESoft\SlimSample\Controller;

use ESoft\SlimSample\Exception\InvalidContactException;
use ESoft\SlimSample\Validator\ContactValidator;
use ESoft\SlimSample\Model\Contact;
use ESoft\SlimSample\Model\PhoneNumber;
use ESoft\SlimSample\Model\Address;
use ESoft\SlimSample\ContactService;

final class ContactsController
{

    protected $contactService;

    public function __construct(ContactService $contactService)
    {
        $this->contactService = $contactService;
    }

    public function getContacts($request, $response, $args)
    {
        $result = Contact::with('phoneNumbers', 'addresses')->get();
        return $response->withJson($result->toArray());
    }

    public function getContact($request, $response, $args)
    {
        $result = $this->contactService->findContact($args['id']);
        return $response->withJson($result->toArray());
    }

    public function createContact($request, $response, $args)
    {
        $contactData = $request->getParsedBody();
        if (!$contactData) {
            throw new \UnexpectedValueException('The contact data is required');
        }
        $this->contactService->validate($contactData);
        $contact = $this->contactService->buildContact($contactData);
        return $response->withJson($this->contactService->marshallContact($contact))->withStatus(201);
    }

    public function updateContact($request, $response, $args)
    {
        $contactData = $request->getParsedBody();
        $contactData['id'] = $args['id'];
        $this->contactService->findContact($args['id']);
        $this->contactService->validate($contactData);
        $contact = $this->contactService->buildContact($contactData);
        return $response->withJson($this->contactService->marshallContact($contact));
    }

    public function deleteContact($request, $response, $args)
    {
        $contact = $this->contactService->findContact($args['id']);
        $contact->delete();
        return $response->withStatus(204);
    }
}
