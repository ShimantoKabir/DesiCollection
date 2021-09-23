<?php
/**
 * Created by PhpStorm.
 * User: kabir
 * Date: 9/23/2021
 * Time: 10:51 AM
 */

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class MenuSeeder extends Seeder
{

    /**
     * Run the database seeds.
     * php artisan db:seed --class=MenuSeeder
     * @return void
     */
    public function run()
    {
        $menus = [
            [
                "oid" => 101,
                "href" => "/user",
                "text" => ""
            ]
        ];
    }

}