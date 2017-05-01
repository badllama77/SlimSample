<?php

namespace ESoft\SlimSample\Model;

use Illuminate\Database\Capsule\Manager;
use Illuminate\Database\Eloquent\Model;

class Address extends Model
{
    protected $table = "addresses";
    protected $fillable = [
        'address_type',
        'city',
        'state',
        'zipcode',
        'street_line1',
        'street_line2'
    ];

    public function contacts()
    {
        return $this->belongsTo('ESoft\SlimSample\Model\Contact');
    }
}
