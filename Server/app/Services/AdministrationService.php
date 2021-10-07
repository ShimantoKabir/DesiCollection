<?php
/**
 * Created by PhpStorm.
 * User: kabir
 * Date: 9/28/2021
 * Time: 11:08 AM
 */

namespace App\Services;

use App\Models\UserInfo;
use App\Repositories\MenuRpo;
use Exception;
use Illuminate\Http\Request;

class AdministrationService
{

    public static function checkPermission(Request $request)
    {

        $res = [
          "msg"=>"",
          "code"=>""
        ];
        $userInfo = $request->userInfo;
        $path = $userInfo["href"];
        $operation = $userInfo["operation"];

        try{

            $userInfos = UserInfo::where('email', $userInfo['email'])
                ->where('session_id', $userInfo['sessionId'])
                ->get();

            if (count($userInfos) > 0) {

                $u = $userInfos[0];
                $opAccess = $u->op_access;
                $roleOid = $u->role_oid;
                $sessionId = $u->session_id;

                $menuRequest = new Request([
                    'userInfo' => [
                        "roleOid" => $roleOid,
                        "sessionId" => $sessionId,
                        "email" => $userInfo['email'],
                        "path" => $path
                    ],
                ]);

                $menus = MenuRpo::getAuthorizedMenusByUserInfo($menuRequest);
                $paths = $menus['paths'];

                if (in_array($path, $paths))
                {
                    if (str_contains($opAccess, $operation)) {
                        $res["msg"] = "All permission ok!";
                        $res["code"] = 200;
                        $res['authInfo'] = $u;
                    } else {
                        $res["msg"] = "You don't have the permission to do this action!";
                        $res["code"] = 404;
                    }
                }
                else
                {
                    $res["msg"]="You don't have permission to access this page!";
                    $res["code"] = 404;
                }

            }else{
                $res["msg"]="Session expired!";
                $res["code"] = 404;
            }

        }catch (Exception $e){
            $res["msg"]=$e->getMessage();
            $res["code"] = 404;
        }

        return $res;

    }

}