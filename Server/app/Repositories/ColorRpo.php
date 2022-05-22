<?php
/**
 * Created by PhpStorm.
 * User: kabir
 * Date: 11/3/2021
 * Time: 10:45 AM
 */

namespace App\Repositories;

use App\Models\Color;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ColorRpo
{

    public static function getInitialData(Request $request)
    {

        $res = [
            'msg' => '',
            'code' => '',
            'productColorViewModel' => [
                "productColors" => []
            ]
        ];

        try {

            $res["productColorViewModel"]["productColors"] = Color::select("id","colorName")
                ->get();
            $res["code"] = 200;
            $res["msg"] = "Initial data fetched successfully!";

        }catch (\Exception $e) {
            $res['msg'] = $e->getMessage();
            $res['code'] = 404;
        }

        return response()->json($res, 200);

    }

    public static function create(Request $request)
    {

        $res = [
            'msg' => '',
            'code' => '',
            'productColorViewModel' => [
                "productColors" => []
            ]
        ];

        $productColorViewModel = $request->productColorViewModel;
        $authInfo = $request->authInfo;

        DB::beginTransaction();
        try {

            $isColorNameExist = Color::where("colorName",$productColorViewModel["colorName"])->exists();

            if ($isColorNameExist){

                $res["code"] = 404;
                $res["msg"] = "Color name already exists!";

            }else{

                $r = new Color();
                $r->colorName = $productColorViewModel["colorName"];
                $r->createdAt = date('Y-m-d H:i:s');
                $r->modifiedBy = $authInfo['id'];
                $r->ip = $request->ip();
                $r->save();

                DB::commit();

                $res["productColorViewModel"]["productColors"] = Color::select("id","colorName")
                    ->get();
                $res["code"] = 200;
                $res["msg"] = "Product color save successfully!";
            }

        }catch (\Exception $e) {
            $res['msg'] = $e->getMessage();
            $res['code'] = 404;
        }

        return response()->json($res, 200);

    }

    public static function update(Request $request)
    {

        $res = [
            'msg' => "",
            'code' => "",
            'productColorViewModel' => [
                "productColors" => []
            ]
        ];

        $productColorViewModel = $request->productColorViewModel;
        $authInfo = $request->authInfo;

        DB::beginTransaction();
        try {

            $isColorNameExist = Color::where("colorName",$productColorViewModel["colorName"])->exists();

            if ($isColorNameExist){

                $res["code"] = 404;
                $res["msg"] = "Color name already exists!";

            }else{

                Color::where("id",$productColorViewModel["id"])
                    ->update([
                        "colorName" => $productColorViewModel["colorName"],
                        "modifiedBy" => $authInfo["id"],
                        "updatedAt" => date('Y-m-d H:i:s'),
                        "ip" => $request->ip()
                    ]);

                DB::commit();

                $res["productColorViewModel"]["productColors"] = Color::select("id","colorName")
                    ->get();
                $res["code"] = 200;
                $res["msg"] = "Product color updated successfully!";
            }

        }catch (\Exception $e) {
            $res['msg'] = $e->getMessage();
            $res['code'] = 404;
        }

        return response()->json($res, 200);

    }

    public static function delete(Request $request)
    {

        $res = [
            'msg' => "",
            'code' => "",
            'productColorViewModel' => [
                "productColors" => []
            ]
        ];

        $productColorViewModel = $request->productColorViewModel;

        DB::beginTransaction();
        try {

            Color::where("id",$productColorViewModel["id"])->delete();

            DB::commit();

            $res["productColorViewModel"]["productColors"] = Color::select("id","colorName")->get();
            $res["code"] = 200;
            $res["msg"] = "Product color deleted successfully!";

        }catch (\Exception $e) {
            $res['msg'] = $e->getMessage();
            $res['code'] = 404;
        }

        return response()->json($res, 200);
    }
}
