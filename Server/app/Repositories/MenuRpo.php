<?php
/**
 * Created by PhpStorm.
 * User: kabir
 * Date: 9/26/2021
 * Time: 11:31 AM
 */

namespace App\Repositories;


use App\Models\UserInfo;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class MenuRpo
{

    public static function getAuthorizedMenusByUserInfo(Request $request){

        $res = [
            'msg' => '',
            'code' => ''
        ];

        $userInfo = $request->userInfo;

        DB::beginTransaction();
        try {

            $menuQuery = strtr("select 
                menus.oid, 
                menus.href, 
                menus.icon, 
                menus.tree_id AS treeId,
                menus.menu_name AS menuName,
                menus.parent_tree_id AS parentTreeId,
                menu_permission_for_roles.role_oid AS roleOid,
                menu_permission_for_roles.menu_oid AS menuOid
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
                    "@roleOid" => $userInfo["roleOid"],
                    "@sessionId" => $userInfo["sessionId"]
                ]
            );

            $menus = DB::select($menuQuery);
            $paths = [];

            foreach ($menus as $key => $val){
                if (!is_null($val->href)){
                    array_push($paths, $val->href);
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

    public static function getMenusByRole($request,$roleOid)
    {

        $res = [
            'msg' => '',
            'code' => ''
        ];


        try{

            $menuQuery = strtr("select 
                menus.oid, 
                menus.href, 
                menus.icon, 
                menus.tree_id AS treeId,
                menus.menu_name AS menuName,
                menus.parent_tree_id AS parentTreeId,
                menu_permission_for_roles.role_oid AS roleOid,
                menu_permission_for_roles.menu_oid AS menuOid
            from
                menus
            inner join menu_permission_for_roles on
                menus.oid = menu_permission_for_roles.menu_oid
            where
                menu_permission_for_roles.role_oid = @roleOid;",
                [
                    "@roleOid" => $roleOid
                ]
            );

            $res['menus'] = DB::select($menuQuery);
            $res['msg'] = "Fetched menus successfully by role!";
            $res['code'] = 200;

        }catch (\Exception $e) {
            $res['msg'] = $e->getMessage();
            $res['code'] = 404;
        }

        return response()->json($res, 200);

    }

}