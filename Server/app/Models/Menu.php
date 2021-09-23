<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Menu extends Model
{
    protected $table = "Menu";
    public $timestamps = false;
    protected $fillable = [
        'id',
        'oid',
        'href',
        'icon',
        'tree_id',
        'for_whom',
        'menu_name',
        'is_active',
        'tree_parent_id',
        'created_at',
        'updated_at'
    ];
}
