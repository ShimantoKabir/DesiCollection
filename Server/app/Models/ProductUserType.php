<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProductUserType extends Model
{
    protected $table = "ProductUserType";
    public $timestamps = false;
    protected $fillable = [
        'id',
        'user_type_name',
        'ip',
        'created_at',
        'updated_at',
        'modified_by'
    ];
}
