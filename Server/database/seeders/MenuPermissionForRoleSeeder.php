<?php
/**
 * Created by PhpStorm.
 * User: kabir
 * Date: 9/24/2021
 * Time: 11:53 AM
 */

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class MenuPermissionForRoleSeeder extends Seeder
{

    /**
     * Run the database seeds.
     * php artisan db:seed --class=MenuPermissionForRoleSeeder
     * @return void
     */
    public function run()
    {

        $menuPermissionForRoles = [
            ["role_oid" => 101, "menu_oid" => 101],
            ["role_oid" => 101, "menu_oid" => 102],
            ["role_oid" => 101, "menu_oid" => 103],
            ["role_oid" => 101, "menu_oid" => 104],
            ["role_oid" => 101, "menu_oid" => 105],
            ["role_oid" => 101, "menu_oid" => 106],
            ["role_oid" => 101, "menu_oid" => 107],
            ["role_oid" => 101, "menu_oid" => 108],
            ["role_oid" => 101, "menu_oid" => 109],
            ["role_oid" => 101, "menu_oid" => 110],
            ["role_oid" => 101, "menu_oid" => 111],
            ["role_oid" => 101, "menu_oid" => 112],
            ["role_oid" => 101, "menu_oid" => 113],
            ["role_oid" => 101, "menu_oid" => 114],
            ["role_oid" => 101, "menu_oid" => 115],
            ["role_oid" => 101, "menu_oid" => 116],
            ["role_oid" => 101, "menu_oid" => 117],
            ["role_oid" => 101, "menu_oid" => 118],
            ["role_oid" => 101, "menu_oid" => 119],
            ["role_oid" => 101, "menu_oid" => 120],
            ["role_oid" => 101, "menu_oid" => 121],
            ["role_oid" => 101, "menu_oid" => 122],
            ["role_oid" => 101, "menu_oid" => 123],
            ["role_oid" => 102, "menu_oid" => 101],
            ["role_oid" => 102, "menu_oid" => 102],
            ["role_oid" => 102, "menu_oid" => 103],
            ["role_oid" => 102, "menu_oid" => 104],
            ["role_oid" => 102, "menu_oid" => 105],
            ["role_oid" => 102, "menu_oid" => 106],
            ["role_oid" => 102, "menu_oid" => 107],
            ["role_oid" => 102, "menu_oid" => 108],
            ["role_oid" => 102, "menu_oid" => 109],
            ["role_oid" => 102, "menu_oid" => 110],
            ["role_oid" => 102, "menu_oid" => 111],
            ["role_oid" => 102, "menu_oid" => 112],
            ["role_oid" => 102, "menu_oid" => 113],
            ["role_oid" => 102, "menu_oid" => 115],
            ["role_oid" => 104, "menu_oid" => 104],
            ["role_oid" => 104, "menu_oid" => 105],
            ["role_oid" => 104, "menu_oid" => 106],
            ["role_oid" => 104, "menu_oid" => 107],
            ["role_oid" => 104, "menu_oid" => 108],
            ["role_oid" => 104, "menu_oid" => 109],
            ["role_oid" => 104, "menu_oid" => 110],
            ["role_oid" => 104, "menu_oid" => 111],
            ["role_oid" => 104, "menu_oid" => 112],
            ["role_oid" => 104, "menu_oid" => 113],
            ["role_oid" => 104, "menu_oid" => 115],
            ["role_oid" => 104, "menu_oid" => 116],
            ["role_oid" => 104, "menu_oid" => 117],
            ["role_oid" => 104, "menu_oid" => 118],
            ["role_oid" => 104, "menu_oid" => 119]
        ];

        DB::table('menu_permission_for_roles')->truncate();

        foreach ($menuPermissionForRoles as $key => $val) {

            DB::table('menu_permission_for_roles')->insert([
                "role_oid" => $val['role_oid'],
                "menu_oid" => $val['menu_oid']
            ]);
        }

    }

}
