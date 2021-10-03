<?php
/**
 * Created by PhpStorm.
 * User: kabir
 * Date: 10/3/2021
 * Time: 12:00 PM
 */

namespace App\Http\Controllers;

use App\Repositories\RoleRpo;
use App\Services\AdministrationService;
use Illuminate\Http\Request;

class RoleCtl  extends Controller
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
            return RoleRpo::getInitialData($request);
        }else {
            return $administrationRes;
        }

    }


    public function create(Request $request)
    {

        $permissionRequest = self::createRequest($request,"R");
        $administrationRes = AdministrationService::checkPermission($permissionRequest);

        if($administrationRes["code"] == 200){
            return RoleRpo::create($request);
        }else {
            return $administrationRes;
        }

    }

    public function update(Request $request,$oid)
    {

        $permissionRequest = self::createRequest($request,"R");
        $administrationRes = AdministrationService::checkPermission($permissionRequest);

        if($administrationRes["code"] == 200){
            return RoleRpo::update($request,$oid);
        }else {
            return $administrationRes;
        }

    }


}