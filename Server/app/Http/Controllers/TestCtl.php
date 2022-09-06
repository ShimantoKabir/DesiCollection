<?php
/**
 * Created by PhpStorm.
 * User: kabir
 * Date: 9/25/2021
 * Time: 5:13 PM
 */

namespace App\Http\Controllers;

use App\Enums\CustomResponseCode;
use App\Enums\CustomResponseMsg;
use App\Models\CustomResponse;
use App\Models\UserInfo;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response as HttpResponseCodes;
use Illuminate\Support\Facades\Artisan;

class TestCtl extends Controller
{
    public function testApi(Request $request) : JsonResponse
    {
        $res = new CustomResponse();
        $res->setMsg(CustomResponseMsg::SUCCESS->value);
        $res->setCode(CustomResponseCode::SUCCESS->value);
        return response()->json($res, HttpResponseCodes::HTTP_OK);
    }

    public function testDB(Request $request) : JsonResponse
    {
        $userInfos = UserInfo::all()->toArray();
        $res = new CustomResponse();
        $res->setMsg(CustomResponseMsg::SUCCESS->value);
        $res->setCode(CustomResponseCode::SUCCESS->value);
        $res->setBrands($userInfos);
        return response()->json($res, HttpResponseCodes::HTTP_OK);
    }

    public function clearCache(Request $request) : JsonResponse
    {
        $exitCode = Artisan::call('cache:clear');
        $exitCode = Artisan::call('config:clear');
        $res = new CustomResponse();
        $res->setMsg(CustomResponseMsg::SUCCESS->value);
        $res->setCode(CustomResponseCode::SUCCESS->value);
        return response()->json($res, HttpResponseCodes::HTTP_OK);
    }
}
