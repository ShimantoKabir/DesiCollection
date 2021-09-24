<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class UserInfoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     * php artisan db:seed --class=UserInfoSeeder
     * @return void
     */
    public function run()
    {
        $userInfos = [
            [
                "email" => "admin247@mail.com",
                "for_whom" => 1,
                "role_oid" => 101,
                "password" => sha1("Admin247@"),
                "op_access" => "CRUD",
                "is_active" => 1,
                "is_approved" => 1,
                "restricted_menu_oid" => null
            ],
            [
                "email" => "developer247@mail.com",
                "for_whom" => 1,
                "role_oid" => 102,
                "password" => sha1("Developer247@"),
                "op_access" => "CRU",
                "is_active" => 1,
                "is_approved" => 1,
                "restricted_menu_oid" => null
            ],
            [
                "email" => "manager247@mail.com",
                "for_whom" => 1,
                "role_oid" => 103,
                "password" => sha1("Manager247@"),
                "op_access" => "CR",
                "is_active" => 1,
                "is_approved" => 1,
                "restricted_menu_oid" => null
            ],
            [
                "email" => "asad247@mail.com",
                "for_whom" => 1,
                "role_oid" => 104,
                "password" => sha1("Asad247@"),
                "op_access" => "R",
                "is_active" => 1,
                "is_approved" => 1,
                "restricted_menu_oid" => "108,109,110"
            ]
        ];

        DB::table('user_infos')->truncate();

        foreach ($userInfos as $key => $val) {

            DB::table('user_infos')->insert([
                "email" => $val['email'],
                "for_whom" => $val['for_whom'],
                "role_oid" => $val['role_oid'],
                "password" => $val['password'],
                "op_access" => $val['op_access'],
                "is_active" => $val['is_active'],
                "is_approved" => $val['is_approved'],
                "restricted_menu_oid" => $val['restricted_menu_oid']
            ]);
        }
    }
}