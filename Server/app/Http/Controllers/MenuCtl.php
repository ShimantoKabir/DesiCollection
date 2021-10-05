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

class MenuCtl extends Controller
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

}