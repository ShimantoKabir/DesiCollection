<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Address extends Model
{
    protected $table = "Address";
    public $timestamps = false;
    protected $fillable = [
        'id',
        'city',
        'email',
        'detail',
        'country',
        'zip_code',
        'link_up_id',
        'address_type',
        'first_mobile_no',
        'second_mobile_no',
        'ip',
        'created_at',
        'updated_at',
        'modified_by'
    ];
}
