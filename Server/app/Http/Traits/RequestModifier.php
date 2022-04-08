<?php

namespace App\Http\Traits;

use App\Services\AdministrationService;
use Illuminate\Http\Request;

trait RequestModifier
{
    public function modifyRequest(Request $request, $operation): array
    {
        $userInfo = $request->userInfo;
        $permissionRequest = new Request([
            'userInfo' => [
                "sessionId" => $userInfo['sessionId'],
                "email" => $userInfo['email'],
                "operation" => $operation,
                "href" => $userInfo['href']
            ],
        ]);

        return AdministrationService::checkPermission($permissionRequest);

    }

    public function mergeRequest(Request $request,array $adminRes): Request
    {
        $request->request->add([
            "authInfo" => $adminRes["authInfo"]
        ]);
        return $request;
    }

}
