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
                "role_name" => "Admin",
                "for_whom" => 1
            ],
            [
                "oid" => 102,
                "role_name" => "Developer",
                "for_whom" => 1
            ],
            [
                "oid" => 103,
                "role_name" => "Manager",
                "for_whom" => 1
            ]
        ];

        DB::table('roles')->truncate();

        foreach ($roles as $key => $val) {

            DB::table('roles')->insert([
                "oid" => $val['oid'],
                "role_name" => $val['role_name'],
                "for_whom" => $val['for_whom']
            ]);
        }

    }

}