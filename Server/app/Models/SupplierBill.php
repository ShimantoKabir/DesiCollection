<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SupplierBill extends Model
{
    protected $table = "SupplierBill";
    public $timestamps = false;
    protected $fillable = [
        'id',
        'supplier_id',
        'bill_number',
        'billing_date',
        'debit_amount',
        'credit_amount',
        'total_quantity',
        'ip',
        'created_at',
        'updated_at',
        'modified_by'
    ];
}
