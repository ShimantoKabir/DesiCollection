<?php
/**
 * Created by PhpStorm.
 * User: kabir
 * Date: 9/24/2021
 * Time: 12:27 PM
 */

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ChartOfAccountSeeder extends Seeder
{
    /**
     * Run the database seeds.
     * php artisan db:seed --class=ChartOfAccountSeeder
     * @return void
     */
    public function run()
    {
        $chartOfAccounts = [
            [
                "oid" => 101,
                "path" => "Asset",
                "org_id" => 101,
                "tree_id" => 1,
                "is_ledger" => 0,
                "account_name" => "Asset",
                "parent_tree_id" => 0,
            ],
            [
                "oid" => 102,
                "path" => "Asset,Cash",
                "org_id" => 101,
                "tree_id" => 2,
                "is_ledger" => 1,
                "account_name" => "Cash",
                "parent_tree_id" => 1,
            ],
            [
                "oid" => 103,
                "path" => "Asset,Bank",
                "org_id" => 101,
                "tree_id" => 3,
                "is_ledger" => 0,
                "account_name" => "Bank",
                "parent_tree_id" => 1,
            ],
            [
                "oid" => 104,
                "path" => "Asset,Bank,Islamic Bank(IBBL)",
                "org_id" => 101,
                "tree_id" => 4,
                "is_ledger" => 1,
                "account_name" => "Islamic Bank(IBBL)",
                "parent_tree_id" => 3
            ],
            [
                "oid" => 105,
                "path" => "Asset,Bank,Dutch Bangla Bank(DBBL)",
                "org_id" => 101,
                "tree_id" => 5,
                "is_ledger" => 1,
                "account_name" => "Dutch Bangla Bank(DBBL)",
                "parent_tree_id" => 3
            ],
            [
                "oid" => 106,
                "path" => "Asset,Bank,Bank Asia",
                "org_id" => 101,
                "tree_id" => 6,
                "is_ledger" => 1,
                "account_name" => "Bank Asia",
                "parent_tree_id" => 3
            ],
            [
                "oid" => 107,
                "path" => "Expanse",
                "org_id" => 101,
                "tree_id" => 7,
                "is_ledger" => 0,
                "account_name" => "Expanse",
                "parent_tree_id" => 0,
            ],
            [
                "oid" => 108,
                "path" => "Expanse,Electricity Bill",
                "org_id" => 101,
                "tree_id" => 8,
                "is_ledger" => 1,
                "account_name" => "Electricity Bill",
                "parent_tree_id" => 7,
            ],
            [
                "oid" => 109,
                "path" => "Expanse,Delivery Cost",
                "org_id" => 101,
                "tree_id" => 9,
                "is_ledger" => 1,
                "account_name" => "Delivery Cost",
                "parent_tree_id" => 7
            ],
            [
                "oid" => 110,
                "path" => "Expanse,Conditional Charge",
                "org_id" => 101,
                "tree_id" => 10,
                "is_ledger" => 1,
                "account_name" => "Conditional Charge",
                "parent_tree_id" => 7
            ],
            [
                "oid" => 111,
                "path" => "Expanse,Shop Rent",
                "org_id" => 101,
                "tree_id" => 11,
                "is_ledger" => 1,
                "account_name" => "Shop Rent",
                "parent_tree_id" => 7
            ],
            [
                "oid" => 112,
                "path" => "Expanse,Employee Salary",
                "org_id" => 101,
                "tree_id" => 12,
                "is_ledger" => 1,
                "account_name" => "Employee Salary",
                "parent_tree_id" => 7
            ],
            [
                "oid" => 113,
                "path" => "Liabilities",
                "org_id" => 101,
                "tree_id" => 13,
                "is_ledger" => 0,
                "account_name" => "Liabilities",
                "parent_tree_id" => 0
            ],
            [
                "oid" => 114,
                "path" => "Equity",
                "org_id" => 101,
                "tree_id" => 14,
                "is_ledger" => 0,
                "account_name" => "Equity",
                "parent_tree_id" => 0
            ],
            [
                "oid" => 115,
                "path" => "Revenue",
                "org_id" => 101,
                "tree_id" => 15,
                "is_ledger" => 0,
                "account_name" => "Revenue",
                "parent_tree_id" => 0
            ]
        ];


        DB::table('chart_of_accounts')->truncate();

        foreach ($chartOfAccounts as $key => $val) {

            DB::table('chart_of_accounts')->insert([
                "oid" => $val['oid'],
                "path" => $val['path'],
                "org_id" => $val['org_id'],
                "tree_id" => $val['tree_id'],
                "is_ledger" => $val['is_ledger'],
                "account_name" => $val['account_name'],
                "parent_tree_id" => $val['parent_tree_id']
            ]);
        }

    }
}
