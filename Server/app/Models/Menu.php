<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Menu extends Model
{
    protected $table = "menus";
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
        'parent_tree_id',
        'ip',
        'created_at',
        'updated_at',
        'modified_by'
    ];
}
