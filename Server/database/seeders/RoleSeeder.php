<?php
/**
 * Created by PhpStorm.
 * User: kabir
 * Date: 9/23/2021
 * Time: 10:02 AM
 */

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class RoleSeeder extends Seeder
{

    /**
     * Run the database seeds.
     * php artisan db:seed --class=RoleSeeder
     * @return void
     */
    public function run()
    {
        $roles = [
            [
                "oid" => 101,
                "power" => 100,
                "for_whom" => 1,
                "role_name" => "Admin",
            ],
            [
                "oid" => 102,
                "power" => 50,
                "for_whom" => 1,
                "role_name" => "Developer",
            ],
            [
                "oid" => 103,
                "power" => 49,
                "for_whom" => 1,
                "role_name" => "Manager",
            ],
            [
                "oid" => 104,
                "power" => 48,
                "for_whom" => 1,
                "role_name" => "Assistant Manager",
            ]
        ];

        DB::table('roles')->truncate();

        foreach ($roles as $key => $val) {

            DB::table('roles')->insert([
                "oid" => $val['oid'],
                "power" => $val['power'],
                "for_whom" => $val['for_whom'],
                "role_name" => $val['role_name']
            ]);
        }

    }

}