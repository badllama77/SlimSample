<?php

namespace ESoft\SlimSample;

use ESoft\SlimSample\Exception\InvalidContactException;
use ESoft\SlimSample\Exception\ContactNotFoundException;
use ESoft\SlimSample\Validator\ContactValidator;
use ESoft\SlimSample\Model\Contact;
use ESoft\SlimSample\Model\PhoneNumber;
use ESoft\SlimSample\Model\Address;

class ContactService
{
    public function buildContact($contactData)
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

    public function findContact($id)
    {
        $contact = Contact::with('phoneNumbers', 'addresses')->find($id);
        if (!$contact) {
            throw new ContactNotFoundException('Contact with id ' . $id . ' not found');
        }
        return $contact;
    }

    public function validate($data)
    {
        $validator = new ContactValidator($data);
        if (!$validator->validate()) {
            throw new InvalidContactException(json_encode($validator->getMessages()));
        }
    }

    public function marshallContact($contact)
    {
        $contact->load('addresses', 'phoneNumbers');
        $result = $contact->toArray();
        $result['location'] = "/contacts/" . $contact['id'];
        return $result;
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
}
