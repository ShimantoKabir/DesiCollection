<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Role extends Model
{
    protected $table = "roles";
    public $timestamps = false;
    protected $fillable = [
        'id',
        'oid',
        'power',
        'for_whom',
        'role_name',
        'ip',
        'created_at',
        'updated_at',
        'modified_by'
    ];
}
