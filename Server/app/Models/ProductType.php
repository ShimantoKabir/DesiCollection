<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProductType extends Model
{
    protected $table = "ProductType";
    public $timestamps = false;
    protected $fillable = [
        'id',
        'type_id',
        'type_name',
        'ip',
        'created_at',
        'updated_at',
        'modified_by'
    ];
}
