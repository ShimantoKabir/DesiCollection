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
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response as HttpResponseCodes;

class TestCtl extends Controller
{
    public function test(Request $request) : JsonResponse
    {
        $res = new CustomResponse();
        $res->setMsg(CustomResponseMsg::SUCCESS->value);
        $res->setCode(CustomResponseCode::SUCCESS->value);
        return response()->json($res, HttpResponseCodes::HTTP_OK);
    }
}
