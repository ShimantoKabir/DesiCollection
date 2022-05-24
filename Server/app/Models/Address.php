<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Address extends Model
{
    protected $table = "addresses";
    public $timestamps = false;
    protected $fillable = [
        'id',
        'city',
        'email',
        'detail',
        'country',
        'zipCode',
        'linkUpId',
        'addressType',
        'firstMobileNo',
        'secondMobileNo',
        'ip',
        'createdAt',
        'updatedAt',
        'modifiedBy'
    ];
}
