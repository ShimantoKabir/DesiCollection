<?php
/**
 * Created by PhpStorm.
 * User: kabir
 * Date: 9/24/2021
 * Time: 12:27 PM
 */

namespace Database\Seeders;

use Database\Factories\ChartOfAccountFactory;
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
        $chartOfAccounts = ChartOfAccountFactory::getData();

        DB::table('chart_of_accounts')->truncate();

        foreach ($chartOfAccounts as $key => $val) {

            DB::table('chart_of_accounts')->insert([
                "oid" => $val['oid'],
                "path" => $val['path'],
                "org_id" => $val['org_id'],
                "tree_id" => $val['tree_id'],
                "is_ledger" => $val['is_ledger'],
                "is_editable" => $val['is_editable'],
                "account_name" => $val['account_name'],
                "parent_tree_id" => $val['parent_tree_id']
            ]);
        }

    }
}
