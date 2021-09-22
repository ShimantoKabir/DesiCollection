<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProductColor extends Model
{
    protected $table = "ProductColor";
    public $timestamps = false;
    protected $fillable = [
        'id',
        'color_name',
        'created_at',
        'updated_at'
    ];
}
