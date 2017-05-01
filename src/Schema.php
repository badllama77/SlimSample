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
}
