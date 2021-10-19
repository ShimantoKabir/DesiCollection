<?php

namespace App\Http\Controllers;

use App\Repositories\AisEntryRpo;
use App\Repositories\ChartOfAccountRpo;
use App\Services\AdministrationService;
use Illuminate\Http\Request;

class AisEntryCtl extends Controller
{

    private static function createRequest(Request $request, $operation): Request
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
            return AisEntryRpo::getInitialData($request);
        }else {
            return $administrationRes;
        }

    }

    public function create(Request $request)
    {

        $permissionRequest = self::createRequest($request,"C");
        $administrationRes = AdministrationService::checkPermission($permissionRequest);

        if($administrationRes["code"] == 200){
            $request->request->add([
                "authInfo" => $administrationRes["authInfo"]
            ]);
            return AisEntryRpo::create($request);
        }else {
            return $administrationRes;
        }

    }

}
