<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ChartOfAccount extends Model
{
    protected $table = "ChartOfAccount";
    public $timestamps = false;
    protected $fillable = [
        'id',
        'oid',
        'srl',
        'path',
        'level',
        'org_id',
        'is_ledger',
        'account_name',
        'created_at',
        'updated_at'
    ];
}
