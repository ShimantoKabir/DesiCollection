<?php
/**
 * Created by PhpStorm.
 * User: kabir
 * Date: 11/3/2021
 * Time: 10:40 AM
 */

namespace App\Http\Controllers;

use App\Repositories\ColorRpo;
use Illuminate\Http\Request;
use App\Services\AdministrationService;

class ColorCtl extends Controller
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
            return ColorRpo::getInitialData($request);
        }else {
            return $administrationRes;
        }

    }


}