<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SupplierBill extends Model
{
    protected $table = "supplier_bills";
    public $timestamps = false;
    protected $fillable = [
        'id',
        'supplierId',
        'billNumber',
        'billingDate',
        'debitAmount',
        'creditAmount',
        'totalQuantity',
        'ip',
        'createdAt',
        'updatedAt',
        'modifiedBy'
    ];
}
