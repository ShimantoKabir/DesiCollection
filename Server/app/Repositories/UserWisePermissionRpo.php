<?php
/**
 * Created by PhpStorm.
 * User: kabir
 * Date: 10/7/2021
 * Time: 10:13 AM
 */

namespace App\Repositories;


use App\Models\UserInfo;
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

            $u = UserInfo::where("id",$userInfo['id'])->first();
            $restrictedMenuOidList = explode(",",$u->restricted_menu_oid);

            $res['menus'] = DB::table('menus')
                ->join('menu_permission_for_roles',
                    'menus.oid',
                    '=',
                    'menu_permission_for_roles.menu_oid'
                )
                ->select(
                    "menus.oid",
                    "menus.href",
                    "menus.icon",
                    "menus.tree_id AS treeId",
                    "menus.menu_name AS menuName",
                    "menus.parent_tree_id AS parentTreeId",
                    "menu_permission_for_roles.role_oid AS roleOid",
                    "menu_permission_for_roles.menu_oid AS menuOid"
                )
                ->where("menu_permission_for_roles.role_oid","=",$userInfo["roleOid"])
                ->get();

            $res['restrictedMenuOidList'] = $restrictedMenuOidList;
            $res['msg'] = "Fetched permitted menus successfully by user!";
            $res['code'] = 200;

        }catch (\Exception $e) {
            $res['msg'] = $e->getMessage();
            $res['code'] = 404;
        }

        return response()->json($res, 200);

    }

    public static function update($request,$userInfoId)
    {

        $res = [
            'msg' => '',
            'code' => ''
        ];

        $authInfo = $request->authInfo;
        $restrictedMenuOidList = $request->restrictedMenuOidList;
        try{

            UserInfo::where("id",$userInfoId)
            ->update([
                "restricted_menu_oid" => join(",",$restrictedMenuOidList),
                "modified_by" => $authInfo['id'],
                "updated_at" => date('Y-m-d H:i:s'),
                "ip" => $request->ip()
            ]);

            DB::commit();

            $res["msg"] = "Restricted menu save successfully!";
            $res["code"] = 200;

        }catch (\Exception $e) {
            $res['msg'] = $e->getMessage();
            $res['code'] = 404;
        }

        return response()->json($res, 200);

    }

}
