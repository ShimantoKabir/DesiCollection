<?php
/**
 * Created by PhpStorm.
 * User: kabir
 * Date: 9/26/2021
 * Time: 11:29 AM
 */

namespace App\Utilities;

use Illuminate\Support\Facades\Hash;

class TokenGenerator
{
    public static function generate(){

        $date = date("Y_m_d_h_i_sa");
        return StringManager::cleanString(Hash::make($date));

    }
}