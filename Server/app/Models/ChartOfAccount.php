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
        'path',
        'org_id',
        'tree_id',
        'is_ledger',
        'account_name',
        'parent_tree_id',
        'created_at',
        'updated_at'
    ];
}
