<?php
/**
 * Created by PhpStorm.
 * User: kabir
 * Date: 10/5/2021
 * Time: 10:45 AM
 */

namespace App\Http\Controllers;
use App\Repositories\MenuPermissionForRoleRpo;
use App\Services\AdministrationService;
use Illuminate\Http\Request;

class MenuPermissionForRoleCtl extends Controller
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


    public function getPermittedMenusByRole(Request $request)
    {

        $permissionRequest = self::createRequest($request,"R");
        $administrationRes = AdministrationService::checkPermission($permissionRequest);

        if($administrationRes["code"] == 200){
            return MenuPermissionForRoleRpo::getPermittedMenusByRole($request);
        }else {
            return $administrationRes;
        }

    }


    public function create(Request $request)
    {

        $permissionRequest = self::createRequest($request,"C");
        $administrationRes = AdministrationService::checkPermission($permissionRequest);

        if($administrationRes["code"] == 200){
            return MenuPermissionForRoleRpo::create($request);
        }else {
            return $administrationRes;
        }

    }

}