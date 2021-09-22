<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProductSize extends Model
{
    protected $table = "ProductSize";
    public $timestamps = false;
    protected $fillable = [
        'id',
        'size_name',
        'created_at',
        'updated_at'
    ];
}
