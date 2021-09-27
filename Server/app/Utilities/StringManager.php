<?php
/**
 * Created by PhpStorm.
 * User: kabir
 * Date: 9/26/2021
 * Time: 11:29 AM
 */

namespace App\Utilities;


class StringManager
{
    public static function cleanString($string){

        $string = str_replace(array('[\', \']'), '', $string);
        $string = preg_replace('/\[.*\]/U', '', $string);
        $string = preg_replace('/&(amp;)?#?[a-z0-9]+;/i', '-', $string);
        $string = htmlentities($string, ENT_COMPAT, 'utf-8');
        $string = preg_replace('/&([a-z])(acute|uml|circ|grave|ring|cedil|slash|tilde|caron|lig|quot|rsquo);/i', '\\1', $string );
        $string = preg_replace(array('/[^a-z0-9]/i', '/[-]+/') , '-', $string);
        return strtolower(trim($string, '-'));

    }

    public static function removeLastPart($string, $delimiter){
        $lastDelPos = strrpos($string, $delimiter);
        $result = substr($string, 0, $lastDelPos);
        return $result;
    }
}