<?php

namespace App\Traits;

use App\Models\CustomResponse;
use App\Services\AdministrationService;
use App\ViewModels\UserInfoViewModel;
use Illuminate\Http\Request;
use JetBrains\PhpStorm\Pure;

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

    #[Pure] public function getAuthInfo(Request $request, $operation): UserInfoViewModel
    {

        $userInfoViewModel = new UserInfoViewModel();

        $userInfo = $request->userInfo;

        $userInfoViewModel->email = $userInfo['email'];
        $userInfoViewModel->sessionId = $userInfo['sessionId'];
        $userInfoViewModel->operation = $operation;
        $userInfoViewModel->href = $userInfo['href'];

        return  $userInfoViewModel;

    }

}
