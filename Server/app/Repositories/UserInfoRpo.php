<?php
/**
 * Created by PhpStorm.
 * User: kabir
 * Date: 9/25/2021
 * Time: 6:43 PM
 */

namespace App\Repositories;


use App\Models\Menu;
use App\Models\UserInfo;
use App\Utilities\TokenGenerator;
use Illuminate\Http\Request;
use Illuminate\Pagination\Paginator;
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

                    $request->request->replace([
                        'userInfo' => $userInfo,
                        'auth' => [
                            "roleOid" => $roleOid,
                            'sessionId' => $sessionId,
                        ]
                    ]);

                    $menus = MenuRpo::getAuthorizedMenusByUserInfo($request);

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

    public static function read($request)
    {


        return null;
    }

}