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
use Illuminate\Http\Request;

class TestCtl extends Controller
{
    public function test(Request $request) : CustomResponse
    {
        $res = new CustomResponse();
        $res->setMsg(CustomResponseMsg::SUCCESS->value);
        $res->setCode(CustomResponseCode::SUCCESS->value);
        return $res;
    }
}
