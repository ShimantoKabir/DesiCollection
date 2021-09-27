<?php
/**
 * Created by PhpStorm.
 * User: kabir
 * Date: 9/26/2021
 * Time: 11:31 AM
 */

namespace App\Repositories;


use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Response;

class MenuRpo
{

    public static function getAuthorizedMenusByUserInfo(Request $request){

        $res = [
            'msg' => '',
            'code' => ''
        ];

        $auth = $request->auth;

        DB::beginTransaction();
        try {

            $menuQuery = strtr("select 
                menus.oid, 
                menus.href, 
                menus.icon, 
                menus.tree_id,
                menus.menu_name,
                menus.parent_tree_id,
                menu_permission_for_roles.role_oid,
                menu_permission_for_roles.menu_oid
            from
                menus
            inner join menu_permission_for_roles on
                menus.oid = menu_permission_for_roles.menu_oid
            where
                menu_permission_for_roles.role_oid = @roleOid
                and menus.oid not in (
                select
                    ifnull(restricted_menu_oid,'')
                from
                    user_infos
                where
                    user_infos.session_id = '@sessionId');",
                [
                    "@roleOid" => $auth["roleOid"],
                    "@sessionId" => $auth["sessionId"]
                ]
            );

            $menus = DB::select($menuQuery);
            $paths = [];

            foreach ($menus as $key => $val){
                if (!is_null($val->href)){
                    array_push($paths,"/dashboard".$val->href);
                }
            }

            $extraPaths = ["/dashboard/user/profile", "/dashboard/notification", "/dashboard/home"];

            foreach ($extraPaths as $val){
                array_push($paths,$val);
            }

            $res['menus'] = $menus;
            $res['paths'] = $paths;
            $res['code'] = 200;
            $res['msg'] = "Menu fetched successfully!";

            DB::commit();
        } catch (\Exception $e) {
            DB::rollback();
            $res['msg'] = $e->getMessage();
            $res['code'] = 404;
        }

        return $res;

    }

}