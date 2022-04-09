<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Fabric extends Model
{
    protected $table = "fabrics";
    public $timestamps = false;
    protected $fillable = [
        'id',
        'fabric_name',
        'ip',
        'created_at',
        'updated_at',
        'modified_by'
    ];
}
