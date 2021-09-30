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

                $res["userInfos"] = DB::table('user_infos')
                    ->join('roles', 'user_infos.role_oid', '=', 'roles.oid')
                    // ->whereNotIn("user_infos.session_id",$userInfo["sessionId"])
                    ->select(
                        'user_infos.id',
                        'user_infos.email',
                        'user_infos.is_active',
                        'user_infos.mobile_number',
                        'roles.role_name'
                    )
                    ->paginate(10);

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

            $roles = Role::select("oid","role_name")->get();
            $userInfos = DB::table('user_infos')
                ->join('roles', 'user_infos.role_oid', '=', 'roles.oid')
                // ->whereNotIn("user_infos.session_id",$userInfo["sessionId"])
                ->select(
                    'user_infos.id',
                    'user_infos.email',
                    'user_infos.is_active',
                    'user_infos.mobile_number',
                    'roles.role_name'
                )
                ->paginate(10);

            $res["roles"] = $roles;
            $res["userInfos"] = $userInfos;
            $res['msg'] = "Initial date fetched successfully!";
            $res['code'] = 200;

        }catch (\Exception $e) {
            $res['msg'] = $e->getMessage();
            $res['code'] = 404;
        }

        return response()->json($res, 200);

    }

}