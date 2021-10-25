<?php
/**
 * Created by PhpStorm.
 * User: kabir
 * Date: 10/25/2021
 * Time: 9:17 AM
 */

namespace App\Http\Controllers;

use App\Repositories\AisReportRpo;
use Illuminate\Http\Request;
use App\Services\AdministrationService;

class AisReportCtl extends Controller
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

    public function showReportByType(Request $request)
    {

        $permissionRequest = self::createRequest($request,"R");
        $administrationRes = AdministrationService::checkPermission($permissionRequest);

        if($administrationRes["code"] == 200){
            $request->request->add([
                "authInfo" => $administrationRes["authInfo"]
            ]);
            return AisReportRpo::showReportByType($request);
        }else {
            return $administrationRes;
        }

    }

}