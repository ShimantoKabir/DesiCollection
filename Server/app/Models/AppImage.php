<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AppImage extends Model
{
    protected $table = "app_images";
    public $timestamps = false;
    protected $fillable = [
        'id',
        'imageName',
        'imageType',
        'isActive',
        'referenceId',
        'ip',
        'createdAt',
        'updatedAt',
        'modifiedBy'
    ];
}
