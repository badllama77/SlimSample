<?php

namespace ESoft\SlimSample\Controller;

use ESoft\SlimSample\Exception\InvalidContactException;
use ESoft\SlimSample\Validator\ContactValidator;
use ESoft\SlimSample\Model\Contact;
use ESoft\SlimSample\Model\PhoneNumber;
use ESoft\SlimSample\Model\Address;

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
        if (!$result) {
            return $response
            ->withJson(['message'=>'Contact with id ' . $args['id'] . ' not found'])
            ->withStatus(404);
        }
        return $response->withJson($result->toArray());
    }

    public function createContact($request, $response, $args)
    {
        $contactData = $request->getParsedBody();
        if (!$contactData) {
            throw new \UnexpectedValueException('The contact data is required');
        }
        $this->validate($contactData);
        $contact = $this->buildContact($contactData);
        $result = $contact->toArray();
        $result['location'] = "/contacts/" . $contact['id'];
        $result['addresses'] = $contact->addresses->toArray();
        $result['phoneNumbers'] = $contact->phoneNumbers->toArray();
        return $response->withJson($result)->withStatus(201);
    }

    public function updateContact($request, $response, $args)
    {
        $contactData = $request->getParsedBody();
        $contactData['id'] = $args['id'];
        $contact = Contact::find($args['id']);
        if (!$contact) {
            return $response
            ->withJson(['message'=>'Contact with id ' . $args['id'] . ' not found'])
            ->withStatus(404);
        }
        $this->validate($contactData);
        $contact = $this->buildContact($contactData);
        $result = $contact->toArray();
        $result['location'] = "/contacts/" . $contact['id'];
        $result['addresses'] = $contact->addresses->toArray();
        $result['phoneNumbers'] = $contact->phoneNumbers->toArray();
        return $response->withJson($result);
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

    private function validate($data)
    {
        $validator = new ContactValidator($data);
        if (!$validator->validate()) {
            throw new InvalidContactException(json_encode($validator->getMessages()));
        }
    }

    private function updateOrCreateMany($class, $data)
    {
        $models=[];
        foreach ($data as $item) {
            if (array_key_exists('id', $item)) {
                $model = $class::find($item['id']);
                $model->update($item);
            } else {
                $model = new $class($item);
            }

            $models[] = $model;
        }
        return $models;
    }

    private function buildContact($contactData)
    {
        $phoneData = [];
        $addressData = [];

        if (array_key_exists('addresses', $contactData)) {
            $addressData = $contactData['addresses'];
            unset($contactData['addresses']);
        }

        if (array_key_exists('phone_numbers', $contactData)) {
            $phoneData = $contactData['phone_numbers'];
            unset($contactData['phone_numbers']);
        }

        $contact = new Contact();
        if (array_key_exists('id', $contactData)) {
            $contact = Contact::find($contactData['id']);
        }

        $contact->fill($contactData);
        $contact->save();
        $contact->phoneNumbers()->saveMany($this->updateOrCreateMany('ESoft\SlimSample\Model\PhoneNumber', $phoneData));
        $contact->addresses()->saveMany($this->updateOrCreateMany('ESoft\SlimSample\Model\Address', $addressData));
        return $contact;
    }
}
