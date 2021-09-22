<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Supplier extends Model
{
    protected $table = "Supplier";
    public $timestamps = false;
    protected $fillable = [
        'id',
        'supplier_id',
        'supplier_name',
        'created_at',
        'updated_at'
    ];
}
