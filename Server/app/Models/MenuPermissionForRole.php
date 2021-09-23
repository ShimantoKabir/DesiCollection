<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MenuPermissionForRole extends Model
{
    protected $table = "MenuPermissionForRole";
    public $timestamps = false;
    protected $fillable = [
        'id',
        'role_oid',
        'menu_oid',
        'created_at',
        'updated_at'
    ];
}
