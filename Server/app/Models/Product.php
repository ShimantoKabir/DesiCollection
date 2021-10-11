<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    protected $table = "Product";
    public $timestamps = false;
    protected $fillable = [
        'id',
        'size_id',
        'color_id',
        'brand_id',
        'quantity',
        'fabric_id',
        'bill_number',
        'user_type_id',
        'purchased_price',
        'product_type_id',
        'offer_percentage',
        'profit_percentage',
        'available_quantity',
        'ip',
        'created_at',
        'updated_at',
        'modified_by'
    ];
}
