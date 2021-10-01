<?php
/**
 * Created by PhpStorm.
 * User: kabir
 * Date: 9/25/2021
 * Time: 6:43 PM
 */

namespace App\Repositories;

use App\Models\Role;
use App\Models\UserInfo;
use App\Utilities\TokenGenerator;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class UserInfoRpo
{

    public static function login(Request $request)
    {

        $res = [
            'msg' => '',
            'code' => ''
        ];

        $userInfo = $request->userInfo;

        DB::beginTransaction();
        try {

            $isUserInfoExists = UserInfo::where('email', $userInfo['email'])->exists();

            if ($isUserInfoExists) {

                $userInfos = UserInfo::where('email', $userInfo['email'])
                    ->where('password', sha1($userInfo['password']))
                    ->get();

                if (count($userInfos) > 0) {

                    $u = $userInfos[0];
                    $sessionId = TokenGenerator::generate();
                    $roleOid = $u->role_oid;

                    UserInfo::where('id', $u->id)->update(array('session_id' => $sessionId));

                    $menus = MenuRpo::getAuthorizedMenusByUserInfo(new Request([
                        'userInfo' => [
                            'email' => $u->email,
                            "roleOid" => $roleOid,
                            'sessionId' => $sessionId,
                        ]
                    ]));

                    $userInfo = [
                        'email' => $u->email,
                        'sessionId' => $sessionId,
                        'menus' => $menus["menus"],
                        'paths' => $menus['paths']
                    ];

                    $res['userInfo'] = $userInfo;
                    $res['msg'] = 'Login successful!';
                    $res['code'] = 200;

                } else {

                    $res['msg'] = 'Incorrect password.';
                    $res['code'] = 404;

                }

            } else {

                $res['msg'] = 'This email address did not belong to any account!';
                $res['code'] = 404;

            }

            DB::commit();
        } catch (\Exception $e) {
            DB::rollback();
            $res['msg'] = $e->getMessage();
            $res['code'] = 404;
        }

        return response()->json($res, 200);

    }

    public static function reload($request)
    {

        $res = [
            'msg' => '',
            'code' => ''
        ];

        $userInfo = $request->userInfo;

        DB::beginTransaction();
        try {

            $userInfos = UserInfo::where('email', $userInfo['email'])
                ->where('session_id', $userInfo['sessionId'])
                ->get();

            if (count($userInfos) > 0) {

                $u = $userInfos[0];
                $roleOid = $u->role_oid;
                $sessionId = $u->session_id;

                $request->request->replace([
                    'userInfo' => [
                        "roleOid" => $roleOid,
                        "sessionId" => $sessionId,
                        "email" => $userInfo['email']
                    ],
                ]);

                $menus = MenuRpo::getAuthorizedMenusByUserInfo($request);

                $userInfo = [
                    'email' => $u->email,
                    'sessionId' => $sessionId,
                    'menus' => $menus["menus"],
                    'paths' => $menus['paths']
                ];

                $res['userInfo'] = $userInfo;
                $res['msg'] = 'User info reload successfully!';
                $res['code'] = 200;

            } else {

                $res['msg'] = 'Session expired!';
                $res['code'] = 404;

            }

        } catch (\Exception $e) {
            $res['msg'] = $e->getMessage();
            $res['code'] = 404;
        }

        return response()->json($res, 200);

    }

    public static function create($request)
    {
        $res = [
            'msg' => '',
            'code' => ''
        ];

        $userInfo = $request->newUserInfo;
        DB::beginTransaction();
        try {

            $isEmailAlreadyExist = UserInfo::where("email",$userInfo["email"])->exists();

            if ($isEmailAlreadyExist){

                $res["code"] = 404;
                $res["msg"] = "This email address already exists!";

            }else{

                $newUserInfo = new UserInfo();
                $newUserInfo->email = $userInfo["email"];
                $newUserInfo->mobile_number = $userInfo["mobileNumber"];
                $newUserInfo->password = sha1($userInfo["password"]);
                $newUserInfo->role_oid = $userInfo["roleOid"];
                $newUserInfo->op_access = join($userInfo["opAccess"]);
                $newUserInfo->for_whom = 1;
                $newUserInfo->save();

                DB::commit();

                $res["userInfos"] = self::getUserInfos($userInfo["sessionId"]);

                $res["code"] = 200;
                $res["msg"] = "User info save successfully!";
            }

        }catch (\Exception $e) {
            $res['msg'] = $e->getMessage();
            $res['code'] = 404;
        }

        return response()->json($res, 200);
    }

    public static function getInitialData($request)
    {

        $res = [
            'msg' => '',
            'code' => ''
        ];

        $userInfo = $request->userInfo;
        try{

            $roles = Role::select("oid","role_name AS roleName")->get();

            $res["roles"] = $roles;
            $res["userInfos"] =  self::getUserInfos($userInfo["email"]);
            $res['msg'] = "Initial date fetched successfully!";
            $res['code'] = 200;

        }catch (\Exception $e) {
            $res['msg'] = $e->getMessage();
            $res['code'] = 404;
        }

        return response()->json($res, 200);

    }

    public static function update($request)
    {

        $res = [
            'msg' => '',
            'code' => ''
        ];

        $userInfo = $request->userInfo;
        try{

            UserInfo::where("id",$userInfo['id'])
                ->update([
                    "role_oid" => $userInfo["roleOid"],
                    "op_access" => join($userInfo["opAccess"]),
                    "mobile_number" => $userInfo["mobile_number"],
                    "email" => $userInfo["email"],
                    "is_active" => $userInfo["isActive"]
                ]);

            DB::commit();

            $res["userInfos"] = self::getUserInfos($userInfo["email"]);
            $res["res"] = "User info updated successfully!";
            $res["code"] = 200;

        }catch (\Exception $e) {
            $res['msg'] = $e->getMessage();
            $res['code'] = 404;
        }

        return response()->json($res, 200);
    }

    private static function getUserInfos($email)
    {

        return DB::table('user_infos')
            ->join('roles', 'user_infos.role_oid', '=', 'roles.oid')
            ->whereNotIn("user_infos.email",[$email])
            ->select(
                'user_infos.id',
                'user_infos.email',
                'user_infos.is_active AS isActive',
                'user_infos.mobile_number AS mobileNumber',
                'user_infos.role_oid AS roleOid',
                'user_infos.op_access AS opAccess',
                'roles.role_name AS roleName'
            )
            ->paginate(10);

    }

}