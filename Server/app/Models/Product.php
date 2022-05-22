<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    protected $table = "products";
    public $timestamps = false;
    protected $fillable = [
        'id',
        'code',
        'typeId',
        'sizeId',
        'colorId',
        'brandId',
        'fabricId',
        'userAgeId',
        'userTypeId',
        'billNumber',
        'totalQuantity',
        'availableQuantity',
        'maxOfferPercentage',
        'maxProfitPercentage',
        'singlePurchasePrice',
        'imageIds',
        'ip',
        'createdAt',
        'updatedAt',
        'modifiedBy'
    ];
}
