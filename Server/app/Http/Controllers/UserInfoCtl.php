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

    public function login(Request $request)
    {
        return UserInfoRpo::login($request);
    }

    public function reload(Request $request)
    {
        return UserInfoRpo::reload($request);
    }

    public function getInitialData(Request $request)
    {

        $permissionRequest = self::createRequest($request,"R");
        $administrationRes = AdministrationService::checkPermission($permissionRequest);

        if($administrationRes["code"] == 200){
            return UserInfoRpo::getInitialData($request);
        }else {
            return $administrationRes;
        }

    }

    public function create(Request $request)
    {

        $permissionRequest = self::createRequest($request,"C");
        $administrationRes = AdministrationService::checkPermission($permissionRequest);

        if($administrationRes["code"] == 200){
            return UserInfoRpo::create($request);
        }else {
            return $administrationRes;
        }

    }

    public function update(Request $request)
    {

        $permissionRequest = self::createRequest($request,"U");
        $administrationRes = AdministrationService::checkPermission($permissionRequest);

        if($administrationRes["code"] == 200){
            return UserInfoRpo::update($request);
        }else {
            return $administrationRes;
        }

    }

}