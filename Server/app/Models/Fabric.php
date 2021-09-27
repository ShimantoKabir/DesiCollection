<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Fabric extends Model
{
    protected $table = "Fabric";
    public $timestamps = false;
    protected $fillable = [
        'id',
        'fabric_name',
        'created_at',
        'updated_at'
    ];
}