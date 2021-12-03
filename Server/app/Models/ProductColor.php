<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProductColor extends Model
{
    protected $table = "product_colors";
    public $timestamps = false;
    protected $fillable = [
        'id',
        'color_name',
        'ip',
        'created_at',
        'updated_at',
        'modified_by'
    ];
}
