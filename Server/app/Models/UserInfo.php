<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UserInfo extends Model
{
    protected $table = "user_infos";
    public $timestamps = false;
    protected $fillable = [
        'id',
        'email',
        'token',
        'for_whom',
        'role_oid',
        'password',
        'last_name',
        'op_access',
        'user_name',
        'is_active',
        'session_id',
        'first_name',
        'is_approved',
        'mobile_number',
        'social_login_id',
        'restricted_menu_oid',
        'ip',
        'created_at',
        'updated_at',
        'modified_by'
    ];
}
