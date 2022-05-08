<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProductUserAge extends Model
{
    protected $table = "product_user_ages";
    public $timestamps = false;
    protected $fillable = [
        'id',
        'minAge',
        'maxAge',
        'fixedAge',
        'ip',
        'createdAt',
        'updatedAt',
        'modifiedBy'
    ];
}
