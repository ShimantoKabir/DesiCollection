<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ChartOfAccount extends Model
{
    protected $table = "chart_of_accounts";
    public $timestamps = false;
    protected $fillable = [
        'id',
        'oid',
        'path',
        'org_id',
        'tree_id',
        'is_ledger',
        'is_editable',
        'account_name',
        'parent_tree_id',
        'ip',
        'created_at',
        'updated_at',
        'modified_by'
    ];
}
