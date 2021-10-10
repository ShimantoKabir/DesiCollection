<?php
/**
 * Created by PhpStorm.
 * User: kabir
 * Date: 10/7/2021
 * Time: 10:13 AM
 */

namespace App\Repositories;


use Illuminate\Support\Facades\DB;

class UserWisePermissionRpo
{

    public static function getInitialData($request)
    {
        $res = [
            'msg' => '',
            'code' => ''
        ];

        $authInfo = $request->authInfo;
        try{

            $roleOid = $authInfo['role_oid'];

            $userInfos = DB::table('user_infos')
                ->join('roles', 'user_infos.role_oid', '=', 'roles.oid')
                ->whereRaw("roles.power <= (select power from roles where oid = ?)",[$roleOid])
                ->select(
                    'user_infos.id',
                    'user_infos.email',
                    'roles.oid AS roleOid'
                )
                ->get();

            $res['userInfos'] = $userInfos;
            $res['msg'] = "Initial data fetched successfully!";
            $res['code'] = 200;

        }catch (\Exception $e) {
            $res['msg'] = $e->getMessage();
            $res['code'] = 404;
        }

        return response()->json($res, 200);
    }

    public static function getPermittedMenusByUser($request)
    {

        $res = [
            'msg' => '',
            'code' => ''
        ];

        $userInfo = $request->exUserInfo;
        try{
            // hi
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
                    user_infos.id = @id);",
                [
                    "@roleOid" => $userInfo["roleOid"],
                    "@id" => $userInfo["id"]
                ]
            );

            $res['menus'] = DB::select($menuQuery);
            $res['msg'] = "Fetched permitted menus successfully by user!";
            $res['code'] = 200;

        }catch (\Exception $e) {
            $res['msg'] = $e->getMessage();
            $res['code'] = 404;
        }

        return response()->json($res, 200);

    }
}
