<?php

namespace ESoft\SlimSample\Model;

use Illuminate\Database\Capsule\Manager;
use Illuminate\Database\Eloquent\Model;

class Contact extends Model
{
    protected $fillable = [
        'first_name',
        'last_name',
        'title',
        'email'
    ];

    public function phoneNumbers()
    {
        return $this->hasMany('ESoft\SlimSample\Model\PhoneNumber');
    }

    public function addresses()
    {
        return $this->hasMany('ESoft\SlimSample\Model\Address');
    }
}
