<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Brand extends Model
{
    protected $table = "Brand";
    public $timestamps = false;
    protected $fillable = [
        'id',
        'brand_name',
        'created_at',
        'updated_at'
    ];
}
