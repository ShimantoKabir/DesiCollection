<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Fabric extends Model
{
    protected $table = "fabrics";
    public $timestamps = false;
    protected $fillable = [
        'id',
        'fabricName',
        'ip',
        'createdAt',
        'updatedAt',
        'modifiedBy'
    ];

}
