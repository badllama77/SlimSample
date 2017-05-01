<?php

namespace ESoft\SlimSample\Model;

use Illuminate\Database\Capsule\Manager;
use Illuminate\Database\Eloquent\Model;

class PhoneNumber extends Model
{
    protected $table = 'phone_numbers';
    protected $fillable = [
        'phone_type',
        'number'
    ];

    public function contacts()
    {
        return $this->belongsTo('ESoft\SlimSample\Model\Contact');
    }
}
