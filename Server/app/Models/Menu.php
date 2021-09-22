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
        'srl',
        'href',
        'text',
        'icon',
        'level',
        'strength',
        'for_whom',
        'is_active',
        'created_at',
        'updated_at'
    ];
}
