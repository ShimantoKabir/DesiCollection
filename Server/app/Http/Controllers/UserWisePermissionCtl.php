<?php
/**
 * Created by PhpStorm.
 * User: kabir
 * Date: 10/7/2021
 * Time: 10:12 AM
 */

namespace App\Http\Controllers;
use App\Repositories\UserWisePermissionRpo;
use App\Services\AdministrationService;
use Illuminate\Http\Request;

class UserWisePermissionCtl extends Controller
{

    private static function createRequest(Request $request, $operation)
    {
        $userInfo = $request->userInfo;
        return new Request([
            'userInfo' => [
                "sessionId" => $userInfo['sessionId'],
                "email" => $userInfo['email'],
                "operation" => $operation,
                "href" => $userInfo['href']
            ],
        ]);
    }

    public function getInitialData(Request $request)
    {

        $permissionRequest = self::createRequest($request,"R");
        $administrationRes = AdministrationService::checkPermission($permissionRequest);

        if($administrationRes["code"] == 200){
            $request->request->add([
                "authInfo" => $administrationRes["authInfo"]
            ]);
            return UserWisePermissionRpo::getInitialData($request);
        }else {
            return $administrationRes;
        }

    }

    public function getPermittedMenusByUser(Request $request)
    {

        $permissionRequest = self::createRequest($request,"R");
        $administrationRes = AdministrationService::checkPermission($permissionRequest);

        if($administrationRes["code"] == 200){
            $request->request->add([
                "authInfo" => $administrationRes["authInfo"]
            ]);
            return UserWisePermissionRpo::getPermittedMenusByUser($request);
        }else {
            return $administrationRes;
        }

    }

}