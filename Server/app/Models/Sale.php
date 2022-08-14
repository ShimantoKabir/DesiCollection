<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Sale extends Model
{
    protected $table = "sales";
    public $timestamps = false;
    protected $fillable = [
        'id',
        'billNumber',
        'singlePrice',
        'vatPercentage',
        'productCode',
        'productQuantity',
        'ip',
        'createdAt',
        'updatedAt',
        'modifiedBy'
    ];
}
