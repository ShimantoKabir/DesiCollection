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
                "href" => null,
                "icon" => "fas fa-user-cog",
                "tree_id" => 1,
                "for_whom" => 1,
                "menu_name" => "Administration",
                "is_active" => 1,
                "parent_tree_id" => 0
            ],
            [
                "oid" => 102,
                "href" => "/user",
                "icon" => "fas fa-user-plus",
                "tree_id" => 2,
                "for_whom" => 1,
                "menu_name" => "Manage User",
                "is_active" => 1,
                "parent_tree_id" => 1
            ],
            [
                "oid" => 103,
                "href" => "/role",
                "icon" => "fas fa-user-tag",
                "tree_id" => 3,
                "for_whom" => 1,
                "menu_name" => "Manage Role",
                "is_active" => 1,
                "parent_tree_id" => 1
            ],
            [
                "oid" => 104,
                "href" => null,
                "icon" => "fas fa-directions",
                "tree_id" => 4,
                "for_whom" => 1,
                "menu_name" => "Menu",
                "is_active" => 1,
                "parent_tree_id" => 0
            ],
            [
                "oid" => 105,
                "href" => "/menu",
                "icon" => "fas fa-tasks",
                "tree_id" => 5,
                "for_whom" => 1,
                "menu_name" => "Manage",
                "is_active" => 1,
                "parent_tree_id" => 4
            ],
            [
                "oid" => 106,
                "href" => "/menu/role-wise-permission",
                "icon" => "fas fa-id-badge",
                "tree_id" => 6,
                "for_whom" => 1,
                "menu_name" => "Role Wise Permission",
                "is_active" => 1,
                "parent_tree_id" => 4
            ],
            [
                "oid" => 107,
                "href" => "/menu/user-wise-permission",
                "icon" => "fas fa-user-shield",
                "tree_id" => 7,
                "for_whom" => 1,
                "menu_name" => "User Wise Permission",
                "is_active" => 1,
                "parent_tree_id" => 4
            ],
            [
                "oid" => 108,
                "href" => null,
                "icon" => "fas fa-tshirt",
                "tree_id" => 8,
                "for_whom" => 1,
                "menu_name" => "Product",
                "is_active" => 1,
                "parent_tree_id" => 0
            ],
            [
                "oid" => 109,
                "href" => "/color",
                "icon" => "fas fa-fill-drip",
                "tree_id" => 9,
                "for_whom" => 1,
                "menu_name" => "Manage Color",
                "is_active" => 1,
                "parent_tree_id" => 8
            ],
            [
                "oid" => 110,
                "href" => "/fabric",
                "icon" => "fas fa-toilet-paper",
                "tree_id" => 10,
                "for_whom" => 1,
                "menu_name" => "Manage Fabric",
                "is_active" => 1,
                "parent_tree_id" => 8
            ],
            [
                "oid" => 111,
                "href" => "/size",
                "icon" => "fas fa-weight",
                "tree_id" => 11,
                "for_whom" => 1,
                "menu_name" => "Manage Size",
                "is_active" => 1,
                "parent_tree_id" => 8
            ],
            [
                "oid" => 112,
                "href" => "/brand",
                "icon" => null,
                "tree_id" => 12,
                "for_whom" => 1,
                "menu_name" => "Manage Brand",
                "is_active" => 1,
                "parent_tree_id" => 8
            ],
            [
                "oid" => 113,
                "href" => "/product-type",
                "icon" => null,
                "tree_id" => 13,
                "for_whom" => 1,
                "menu_name" => "Product Type",
                "is_active" => 1,
                "parent_tree_id" => 8
            ],
            [
                "oid" => 114,
                "href" => "/product-user-type",
                "icon" => null,
                "tree_id" => 14,
                "for_whom" => 1,
                "menu_name" => "Product User Type",
                "is_active" => 1,
                "parent_tree_id" => 8
            ],
            [
                "oid" => 115,
                "href" => "/product",
                "icon" => null,
                "tree_id" => 15,
                "for_whom" => 1,
                "menu_name" => "Manage Product",
                "is_active" => 1,
                "parent_tree_id" => 8
            ],
            [
                "oid" => 116,
                "href" => null,
                "icon" => "fas fa-book",
                "tree_id" => 16,
                "for_whom" => 1,
                "menu_name" => "AIS",
                "is_active" => 1,
                "parent_tree_id" => 0
            ],
            [
                "oid" => 117,
                "href" => "/chart-of-account",
                "icon" => null,
                "tree_id" => 17,
                "for_whom" => 1,
                "menu_name" => "Chart of Account",
                "is_active" => 1,
                "parent_tree_id" => 16
            ],
            [
                "oid" => 118,
                "href" => "/ais-entry",
                "icon" => null,
                "tree_id" => 18,
                "for_whom" => 1,
                "menu_name" => "Entry",
                "is_active" => 1,
                "parent_tree_id" => 16
            ],
            [
                "oid" => 119,
                "href" => "/ais-report",
                "icon" => null,
                "tree_id" => 19,
                "for_whom" => 1,
                "menu_name" => "Report",
                "is_active" => 1,
                "parent_tree_id" => 16
            ]
        ];


        DB::table('menus')->truncate();

        foreach ($menus as $key => $val) {

            DB::table('menus')->insert([
                "oid" => $val['oid'],
                "href" => $val['href'],
                "icon" => $val['icon'],
                "tree_id" => $val['tree_id'],
                "for_whom" => $val['for_whom'],
                "menu_name" => $val['menu_name'],
                "is_active" => $val['is_active'],
                "parent_tree_id" => $val['parent_tree_id']
            ]);
        }
    }

}