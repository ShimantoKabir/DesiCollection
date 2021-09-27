<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MenuPermissionForRole extends Model
{
    protected $table = "menu_permission_for_roles";
    public $timestamps = false;
    protected $fillable = [
        'id',
        'role_oid',
        'menu_oid',
        'created_at',
        'updated_at'
    ];
}
