<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AccountingTransaction extends Model
{
    protected $table = "accounting_transactions";
    public $timestamps = false;
    protected $fillable = [
        'id',
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
        'ip',
        'created_at',
        'updated_at',
        'modified_by'
    ];
}
