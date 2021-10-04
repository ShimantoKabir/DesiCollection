<?php
/**
 * Created by PhpStorm.
 * User: kabir
 * Date: 10/3/2021
 * Time: 5:47 PM
 */

namespace App\Http\Controllers;

use App\Repositories\MenuRpo;
use App\Services\AdministrationService;
use Illuminate\Http\Request;

class MenuCtl
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

    public function getMenusByRole(Request $request,$roleOid)
    {

        $permissionRequest = self::createRequest($request,"R");
        $administrationRes = AdministrationService::checkPermission($permissionRequest);

        if($administrationRes["code"] == 200){
            return MenuRpo::getMenusByRole($request,$roleOid);
        }else {
            return $administrationRes;
        }

    }

}