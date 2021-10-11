<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AppImage extends Model
{
    protected $table = "AppImage";
    public $timestamps = false;
    protected $fillable = [
        'id',
        'image_url',
        'is_active',
        'reference_id',
        'ip',
        'created_at',
        'updated_at',
        'modified_by'
    ];
}
