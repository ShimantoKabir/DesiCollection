<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProductUserType extends Model
{
    protected $table = "product_user_types";
    public $timestamps = false;
    protected $fillable = [
        'id',
        'userTypeName',
        'ip',
        'createdAt',
        'updatedAt',
        'modifiedBy'
    ];
}
