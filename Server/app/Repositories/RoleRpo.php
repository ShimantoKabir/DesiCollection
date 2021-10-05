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

        $userInfo = $request->userInfo;
        try{

            $roles = Role::select("oid","role_name AS roleName")
                ->where("oid","!=",101)
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
        $authUserInfo = $request->userInfo;

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
                $r->role_name = $role["roleName"];
                $r->for_whom = 1;
                $r->created_at = date('Y-m-d H:i:s');
                $r->modified_by = 1; // $authUserInfo["id"];
                $r->ip = $request->ip();
                $r->save();

                DB::commit();

                $res["roles"] = Role::select("oid","role_name AS roleName")->get();

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
                    "role_name" => $role["roleName"],
                    "modified_by" => 1, //$authUserInfo["id"],
                    "updated_at" => date('Y-m-d H:i:s'), //$authUserInfo["id"],
                    "ip" => $request->ip() //$authUserInfo["id"],
                ]);

            DB::commit();

            $res["roles"] = Role::select("oid","role_name AS roleName")->get();
            $res["res"] = "Role updated successfully!";
            $res["code"] = 200;

        }catch (\Exception $e) {
            $res['msg'] = $e->getMessage();
            $res['code'] = 404;
        }

        return response()->json($res, 200);

    }
}