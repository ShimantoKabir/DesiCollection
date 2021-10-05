<?php
/**
 * Created by PhpStorm.
 * User: kabir
 * Date: 10/5/2021
 * Time: 10:47 AM
 */

namespace App\Repositories;

use App\Models\MenuPermissionForRole;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class MenuPermissionForRoleRpo
{

    public static function getPermittedMenusByRole(Request $request)
    {

        $res = [
            'msg' => '',
            'code' => ''
        ];

        $menuPermissionForRole = $request->menuPermissionForRole;
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
                    "@roleOid" => $menuPermissionForRole["roleOid"]
                ]
            );

            $res['menus'] = DB::select($menuQuery);
            $res['msg'] = "Fetched permitted menus successfully by role!";
            $res['code'] = 200;

        }catch (\Exception $e) {
            $res['msg'] = $e->getMessage();
            $res['code'] = 404;
        }

        return response()->json($res, 200);

    }

    public static function create(Request $request)
    {
        $res = [
            'msg' => '',
            'code' => ''
        ];

        $authUserInfo = $request->userInfo;
        $menuPermissionForRoles = $request->menuPermissionForRoles;

        DB::beginTransaction();
        try {

            $roleOid = $menuPermissionForRoles[0]["roleOid"];
            MenuPermissionForRole::where("role_oid",$roleOid)->delete();

            foreach ($menuPermissionForRoles as $key=>$val){
                $mr = new MenuPermissionForRole();
                $mr->role_oid = $val["roleOid"];
                $mr->menu_oid = $val["menuOid"];
                $mr->created_at = date('Y-m-d H:i:s');
                $mr->modified_by = 1; // $authUserInfo["id"];
                $mr->ip = $request->ip();
                $mr->save();
            }

            DB::commit();

            $res["code"] = 200;
            $res["msg"] = "Permitted menu save successfully!";
        }catch (\Exception $e) {
            $res['msg'] = $e->getMessage();
            $res['code'] = 404;
        }

        return response()->json($res, 200);
    }

}