<?php
/**
 * Created by PhpStorm.
 * User: kabir
 * Date: 10/3/2021
 * Time: 12:01 PM
 */

namespace App\Repositories;


use App\Models\Role;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;

class RoleRpo
{

    public static function getInitialData(Request $request)
    {

        $res = [
            'msg' => '',
            'code' => ''
        ];

        $authInfo = $request->authInfo;
        try{

            $roleOid = $authInfo['role_oid'];

            $roles = Role::select("oid","role_name AS roleName","power")
                ->where("oid","!=",101)
                ->whereRaw("power <= (select power from roles where oid = ?)",[$roleOid])
                ->orderBy("power")
                ->get();

            $res["roles"] = $roles;
            $res['msg'] = "Initial date fetched successfully!";
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

        $role = $request->role;
        $authInfo = $request->authInfo;

        DB::beginTransaction();
        try {

            $isRoleNameExist = Role::where("role_name",$role["roleName"])->exists();

            if ($isRoleNameExist){

                $res["code"] = 404;
                $res["msg"] = "Role name already exists!";

            }else{

                $maxOid = DB::select("SELECT
                  IF(MAX(oId) IS NULL, 101, MAX(oId) + 1) AS oId
                FROM
                  roles")[0]->oId;

                $r = new Role();
                $r->oid = $maxOid;
                $r->power = $role["power"];
                $r->for_whom = 1;
                $r->role_name = $role["roleName"];
                $r->created_at = date('Y-m-d H:i:s');
                $r->modified_by = $authInfo['id'];
                $r->ip = $request->ip();
                $r->save();

                DB::commit();

                $res["roles"] = Role::select("oid","role_name AS roleName","power")
                    ->where("oid","!=",101)
                    ->orderBy("power")
                    ->get();

                $res["code"] = 200;
                $res["msg"] = "Role save successfully!";
            }

        }catch (\Exception $e) {
            $res['msg'] = $e->getMessage();
            $res['code'] = 404;
        }

        return response()->json($res, 200);

    }

    public static function update(Request $request, $oid)
    {

        $res = [
            'msg' => '',
            'code' => ''
        ];

        $role = $request->role;
        $authUserInfo = $request->userInfo;

        DB::beginTransaction();
        try{

            Role::where("oid",$oid)
                ->update([
                    "power" => $role["power"],
                    "role_name" => $role["roleName"],
                    "modified_by" => 1, //$authUserInfo["id"],
                    "updated_at" => date('Y-m-d H:i:s'), //$authUserInfo["id"],
                    "ip" => $request->ip() //$authUserInfo["id"],
                ]);

            DB::commit();

            $res["roles"] = Role::select("oid","role_name AS roleName","power")
                ->where("oid","!=",101)
                ->orderBy("power")
                ->get();

            $res["msg"] = "Role updated successfully!";
            $res["code"] = 200;

        }catch (\Exception $e) {
            $res['msg'] = $e->getMessage();
            $res['code'] = 404;
        }

        return response()->json($res, 200);

    }
}