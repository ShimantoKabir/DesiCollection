<?php
/**
 * Created by PhpStorm.
 * User: kabir
 * Date: 9/25/2021
 * Time: 5:13 PM
 */

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class TestCtl extends Controller
{
    public function test(Request $request)
    {

        $x = $request->all();

        $y = 2;
        $z = 4;

        $l = $y + $z;


        return [
            'request'=>$request->all(),
            'stats'=>'working ....!',
            'res' => $l
        ];
    }
}
