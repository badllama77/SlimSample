<?php

namespace ESoft\SlimSample;

use Illuminate\Database\Capsule\Manager;
use Illuminate\Database\Schema\Blueprint;

class Schema
{
    /**
     * Create needed tables in database.
     */
    public static function createTables()
    {
        self::createContactsTable();
        self::createAddressesTable();
        self::createPhoneNumbersTable();
    }

    private static function createContactsTable()
    {
        if (!Manager::schema()->hasTable('contacts')) {
            Manager::schema()->create('contacts', function (Blueprint $table) {
                $table->increments('id');
                $table->string('first_name');
                $table->string('last_name');
                $table->string('title');
                $table->string('email');
                $table->date('updated_at');
                $table->date('created_at');
            });
        }
    }

    private static function createAddressesTable()
    {
        if (!Manager::schema()->hasTable('addresses')) {
            Manager::schema()->create('addresses', function (Blueprint $table) {
                $table->increments('id');
                $table->string('address_type');
                $table->string('street_line1');
                $table->string('street_line2');
                $table->string('city');
                $table->string('state');
                $table->string('zipcode');
                $table->integer('contact_id');
                $table->date('updated_at');
                $table->date('created_at');
                $table->foreign('contact_id')
                    ->references('id')
                    ->on('contacts')
                    ->onDelete('cascade');
            });
        }
    }

    private static function createPhoneNumbersTable()
    {
        if (!Manager::schema()->hasTable('phone_numbers')) {
            Manager::schema()->create('phone_numbers', function (Blueprint $table) {
                $table->increments('id');
                $table->string('phone_type');
                $table->string('number');
                $table->integer('contact_id');
                $table->date('updated_at');
                $table->date('created_at');
                $table->foreign('contact_id')
                    ->references('id')
                    ->on('contacts')
                    ->onDelete('cascade');
            });
        }
    }
}
