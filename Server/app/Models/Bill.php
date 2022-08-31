<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Bill extends Model
{
    protected $table = "bills";
    public $timestamps = false;
    protected $fillable = [
        'id',
        'number',
        'customerId',
        'givenPrice',
        'isActive',
        'replaceBy',
        'ip',
        'createdAt',
        'updatedAt',
        'modifiedBy'
    ];
}
