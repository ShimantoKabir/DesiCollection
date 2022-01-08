<?php
/**
 * Created by PhpStorm.
 * User: kabir
 * Date: 9/25/2021
 * Time: 5:13 PM
 */

namespace App\Http\Controllers;

use App\Models\ProductColor;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class TestCtl extends Controller
{
    public function test(Request $request)
    {
        return [
            'request'=>$request->all(),
            'stats'=>'working ....!'
        ];
    }

    public function webHook(Request $request)
    {
        $res = [
            'msg' => '',
            'code' => '',
            'productColorViewModel' => [
                "productColors" => []
            ]
        ];


        DB::beginTransaction();
        try {

            $r = new ProductColor();
            $r->color_name = $request->id;
            $r->created_at = date('Y-m-d H:i:s');
            $r->modified_by = 1;
            $r->ip = $request->ip();
            $r->save();

            DB::commit();

            $res["code"] = 200;
            $res["msg"] = "Product color save successfully!";

        }catch (\Exception $e) {
            $res['msg'] = $e->getMessage();
            $res['code'] = 404;
        }

        return response()->json($res, 200);
    }

}