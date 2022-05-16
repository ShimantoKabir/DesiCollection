<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProductType extends Model
{
    protected $table = "product_types";
    public $timestamps = false;
    protected $fillable = [
        'id',
        'typeName',
        'ip',
        'createdAt',
        'updatedAt',
        'modifiedBy'
    ];
}
