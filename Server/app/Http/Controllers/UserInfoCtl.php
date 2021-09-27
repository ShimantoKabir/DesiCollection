<?php
/**
 * Created by PhpStorm.
 * User: kabir
 * Date: 9/25/2021
 * Time: 6:42 PM
 */

namespace App\Http\Controllers;

use App\Repositories\UserInfoRpo;
use Illuminate\Http\Request;

class UserInfoCtl extends Controller
{

    public function login(Request $request)
    {
        return UserInfoRpo::login($request);
    }

    public function reload(Request $request)
    {
        return UserInfoRpo::reload($request);
    }

}