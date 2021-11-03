<?php
/**
 * Created by PhpStorm.
 * User: kabir
 * Date: 11/3/2021
 * Time: 10:45 AM
 */

namespace App\Repositories;

use Illuminate\Http\Request;

class ColorRpo
{

    public static function getInitialData(Request $request)
    {

        $res = [
            "code" => 200,
            "msg" => "OK"
        ];

        return response()->json($res, 200);

    }
}