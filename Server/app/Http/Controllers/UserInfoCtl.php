<?php
/**
 * Created by PhpStorm.
 * User: kabir
 * Date: 9/25/2021
 * Time: 6:42 PM
 */

namespace App\Http\Controllers;

use App\Repositories\UserInfoRpo;
use App\Services\AdministrationService;
use Illuminate\Http\Request;

class UserInfoCtl extends Controller
{

    private static function modifyRequest(Request $request, $operation)
    {
        $userInfo = $request->userInfo;
        $request->request->replace([
            'userInfo' => [
                "sessionId" => $userInfo['sessionId'],
                "email" => $userInfo['email'],
                "operation" => $operation,
            ],
        ]);

        return $request;
    }

    public function login(Request $request)
    {
        return UserInfoRpo::login($request);
    }

    public function reload(Request $request)
    {
        return UserInfoRpo::reload($request);
    }

    public function read(Request $request)
    {

        $request = self::modifyRequest($request,"R");
        $administrationRes = AdministrationService::checkPermission($request);

        if($administrationRes["code"] == 200){
            return UserInfoRpo::read($request);
        }else {
            return $administrationRes;
        }

    }

}