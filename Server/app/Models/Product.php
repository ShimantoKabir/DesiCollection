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
        'minOfferPercentage',
        'minProfitPercentage',
        'singlePurchasePrice',
        'ip',
        'createdAt',
        'updatedAt',
        'modifiedBy'
    ];
}
