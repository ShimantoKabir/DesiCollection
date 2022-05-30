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
                "href" => "/dashboard/administration/user",
                "icon" => "fas fa-user-plus",
                "tree_id" => 2,
                "for_whom" => 1,
                "menu_name" => "Manage User",
                "is_active" => 1,
                "parent_tree_id" => 1
            ],
            [
                "oid" => 103,
                "href" => "/dashboard/administration/role",
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
                "href" => "/dashboard/menu/manage",
                "icon" => "fas fa-tasks",
                "tree_id" => 5,
                "for_whom" => 1,
                "menu_name" => "Manage",
                "is_active" => 1,
                "parent_tree_id" => 4
            ],
            [
                "oid" => 106,
                "href" => "/dashboard/menu/role-wise-permission",
                "icon" => "fas fa-id-badge",
                "tree_id" => 6,
                "for_whom" => 1,
                "menu_name" => "Role Wise Permission",
                "is_active" => 1,
                "parent_tree_id" => 4
            ],
            [
                "oid" => 107,
                "href" => "/dashboard/menu/user-wise-permission",
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
                "href" => "/dashboard/product/color",
                "icon" => "fas fa-fill-drip",
                "tree_id" => 9,
                "for_whom" => 1,
                "menu_name" => "Manage Color",
                "is_active" => 1,
                "parent_tree_id" => 8
            ],
            [
                "oid" => 110,
                "href" => "/dashboard/product/fabric",
                "icon" => "fas fa-toilet-paper",
                "tree_id" => 10,
                "for_whom" => 1,
                "menu_name" => "Manage Fabric",
                "is_active" => 1,
                "parent_tree_id" => 8
            ],
            [
                "oid" => 111,
                "href" => "/dashboard/product/size",
                "icon" => "fas fa-weight",
                "tree_id" => 11,
                "for_whom" => 1,
                "menu_name" => "Manage Size",
                "is_active" => 1,
                "parent_tree_id" => 8
            ],
            [
                "oid" => 112,
                "href" => "/dashboard/product/age",
                "icon" => "fas fa-weight",
                "tree_id" => 12,
                "for_whom" => 1,
                "menu_name" => "Manage Age",
                "is_active" => 1,
                "parent_tree_id" => 8
            ],
            [
                "oid" => 113,
                "href" => "/dashboard/product/brand",
                "icon" => null,
                "tree_id" => 13,
                "for_whom" => 1,
                "menu_name" => "Manage Brand",
                "is_active" => 1,
                "parent_tree_id" => 8
            ],
            [
                "oid" => 114,
                "href" => "/dashboard/product/type",
                "icon" => null,
                "tree_id" => 14,
                "for_whom" => 1,
                "menu_name" => "Product Type",
                "is_active" => 1,
                "parent_tree_id" => 8
            ],
            [
                "oid" => 115,
                "href" => "/dashboard/product/user-type",
                "icon" => null,
                "tree_id" => 15,
                "for_whom" => 1,
                "menu_name" => "Product User Type",
                "is_active" => 1,
                "parent_tree_id" => 8
            ],
            [
                "oid" => 116,
                "href" => "/dashboard/product/manage",
                "icon" => null,
                "tree_id" => 16,
                "for_whom" => 1,
                "menu_name" => "Manage Product",
                "is_active" => 1,
                "parent_tree_id" => 8
            ],
            [
                "oid" => 117,
                "href" => null,
                "icon" => "fas fa-book",
                "tree_id" => 17,
                "for_whom" => 1,
                "menu_name" => "AIS",
                "is_active" => 1,
                "parent_tree_id" => 0
            ],
            [
                "oid" => 118,
                "href" => "/dashboard/ais/chart-of-account",
                "icon" => null,
                "tree_id" => 18,
                "for_whom" => 1,
                "menu_name" => "Chart of Account",
                "is_active" => 1,
                "parent_tree_id" => 17
            ],
            [
                "oid" => 119,
                "href" => "/dashboard/ais/entry",
                "icon" => null,
                "tree_id" => 19,
                "for_whom" => 1,
                "menu_name" => "Entry",
                "is_active" => 1,
                "parent_tree_id" => 17
            ],
            [
                "oid" => 120,
                "href" => "/dashboard/ais/report",
                "icon" => null,
                "tree_id" => 20,
                "for_whom" => 1,
                "menu_name" => "Report",
                "is_active" => 1,
                "parent_tree_id" => 17
            ],
            [
                "oid" => 121,
                "href" => null,
                "icon" => "fas fa-book",
                "tree_id" => 21,
                "for_whom" => 1,
                "menu_name" => "Supplier",
                "is_active" => 1,
                "parent_tree_id" => 0
            ],
            [
                "oid" => 122,
                "href" => "/dashboard/supplier/manage",
                "icon" => null,
                "tree_id" => 22,
                "for_whom" => 1,
                "menu_name" => "Manage",
                "is_active" => 1,
                "parent_tree_id" => 21
            ],
            [
                "oid" => 123,
                "href" => "/dashboard/supplier/bills",
                "icon" => null,
                "tree_id" => 23,
                "for_whom" => 1,
                "menu_name" => "Bill",
                "is_active" => 1,
                "parent_tree_id" => 21
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
