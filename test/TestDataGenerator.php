<?php
namespace ESoft\SlimSample;

use Illuminate\Database\Capsule\Manager;
use ESoft\SlimSample\Model\Contact;
use ESoft\SlimSample\Model\Address;
use ESoft\SlimSample\Model\PhoneNumber;

class TestDataGenerator
{
    public static function populate()
    {
        $contactData = [
            'first_name' => 'Bugs',
            'last_name' => 'Bunny',
            'title' => 'Hasenpfeffer',
            'email' => 'bugs@acme.com'
        ];
        $addressData = [
            [
                'address_type' => 'home',
                'city' => 'Walla Walla',
                'state' => 'WA',
                'zipcode' => '99362',
                'street_line1' => '1313 Mockingbird lane',
                'street_line2' => 'APT 221'
            ]
        ];

        $phoneData = [
            ['phone_type' => 'home', 'number' => '555.555.1234'],
            ['phone_type' => 'work', 'number' => '555.555.1235'],
            ['phone_type' => 'cell', 'number' => '555.555.1236'],
        ];
        $contact = Contact::firstOrCreate($contactData);
        foreach ($phoneData as $data) {
            $phone = PhoneNumber::firstOrNew($data);
            $contact->phoneNumbers()->save($phone);
        }

        foreach ($addressData as $data) {
            $address = Address::firstOrNew($data);
            $contact->addresses()->save($address);
        }
        return $contact;
    }
}
