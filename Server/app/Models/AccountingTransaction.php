<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AccountingTransaction extends Model
{
    protected $table = "AccountingTransaction";
    public $timestamps = false;
    protected $fillable = [
        'id',
        'srl',
        'org_id',
        'dr_amt',
        'cr_amt',
        'chq_no',
        'chq_date',
        'narration',
        'voucher_no',
        'voucher_type',
        'voucher_date',
        'reference_number',
        'chart_of_account_oid',
        'chart_of_account_root_oid',
        'created_at',
        'updated_at'
    ];
}
