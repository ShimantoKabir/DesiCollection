<?php
/**
 * Created by PhpStorm.
 * User: kabir
 * Date: 10/19/2021
 * Time: 10:50 AM
 */

namespace Database\Factories;
use App\Utilities\AppConstant;
use Illuminate\Database\Eloquent\Factories\Factory;


class ChartOfAccountFactory extends Factory
{

    public static function getData()
    {
        return [
            [
                "oid" => 101,
                "path" => "101",
                "org_id" => 101,
                "tree_id" => 1,
                "is_ledger" => 0,
                "is_editable" => 0,
                "account_name" => "Asset",
                "parent_tree_id" => 0,
            ],
            [
                "oid" => 102,
                "path" => "101,102",
                "org_id" => 101,
                "tree_id" => 2,
                "is_ledger" => 1,
                "is_editable" => 0,
                "account_name" => AppConstant::$CASH_ACCOUNT_NAME,
                "parent_tree_id" => 1,
            ],
            [
                "oid" => 103,
                "path" => "101,103",
                "org_id" => 101,
                "tree_id" => 3,
                "is_ledger" => 0,
                "is_editable" => 0,
                "account_name" => "Bank",
                "parent_tree_id" => 1,
            ],
            [
                "oid" => 104,
                "path" => "101,103,104",
                "org_id" => 101,
                "tree_id" => 4,
                "is_ledger" => 1,
                "is_editable" => 0,
                "account_name" => "Islamic Bank(IBBL)",
                "parent_tree_id" => 3
            ],
            [
                "oid" => 105,
                "path" => "101,103,105",
                "org_id" => 101,
                "tree_id" => 5,
                "is_ledger" => 1,
                "is_editable" => 0,
                "account_name" => "Dutch Bangla Bank(DBBL)",
                "parent_tree_id" => 3
            ],
            [
                "oid" => 106,
                "path" => "101,103,106",
                "org_id" => 101,
                "tree_id" => 6,
                "is_ledger" => 1,
                "is_editable" => 0,
                "account_name" => "Bank Asia",
                "parent_tree_id" => 3
            ],
            [
                "oid" => 107,
                "path" => "107",
                "org_id" => 101,
                "tree_id" => 7,
                "is_ledger" => 0,
                "is_editable" => 0,
                "account_name" => "Expanse",
                "parent_tree_id" => 0,
            ],
            [
                "oid" => 108,
                "path" => "107,108",
                "org_id" => 101,
                "tree_id" => 8,
                "is_ledger" => 1,
                "is_editable" => 0,
                "account_name" => "Electricity Bill",
                "parent_tree_id" => 7,
            ],
            [
                "oid" => 109,
                "path" => "107,109",
                "org_id" => 101,
                "tree_id" => 9,
                "is_ledger" => 1,
                "is_editable" => 0,
                "account_name" => "Delivery Cost",
                "parent_tree_id" => 7
            ],
            [
                "oid" => 110,
                "path" => "107,110",
                "org_id" => 101,
                "tree_id" => 10,
                "is_ledger" => 1,
                "is_editable" => 0,
                "account_name" => "Conditional Charge",
                "parent_tree_id" => 7
            ],
            [
                "oid" => 111,
                "path" => "107,111",
                "org_id" => 101,
                "tree_id" => 11,
                "is_ledger" => 1,
                "is_editable" => 0,
                "account_name" => "Shop Rent",
                "parent_tree_id" => 7
            ],
            [
                "oid" => 112,
                "path" => "107,112",
                "org_id" => 101,
                "tree_id" => 12,
                "is_ledger" => 1,
                "is_editable" => 0,
                "account_name" => "Employee Salary",
                "parent_tree_id" => 7
            ],
            [
                "oid" => 113,
                "path" => "113",
                "org_id" => 101,
                "tree_id" => 13,
                "is_ledger" => 0,
                "is_editable" => 0,
                "account_name" => "Liabilities",
                "parent_tree_id" => 0
            ],
            [
                "oid" => 114,
                "path" => "114",
                "org_id" => 101,
                "tree_id" => 14,
                "is_ledger" => 0,
                "is_editable" => 0,
                "account_name" => "Equity",
                "parent_tree_id" => 0
            ],
            [
                "oid" => 115,
                "path" => "115",
                "org_id" => 101,
                "tree_id" => 15,
                "is_ledger" => 0,
                "is_editable" => 0,
                "account_name" => "Revenue",
                "parent_tree_id" => 0
            ],
            [
                "oid" => 116,
                "path" => "115,116",
                "org_id" => 101,
                "tree_id" => 16,
                "is_ledger" => 1,
                "is_editable" => 0,
                "account_name" => "Online Sales",
                "parent_tree_id" => 15
            ],
            [
                "oid" => 117,
                "path" => "115,117",
                "org_id" => 101,
                "tree_id" => 17,
                "is_ledger" => 1,
                "is_editable" => 0,
                "account_name" => "In-Shop Sales",
                "parent_tree_id" => 15
            ]
        ];
    }

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        // TODO: Implement definition() method.
        return [];
    }
}