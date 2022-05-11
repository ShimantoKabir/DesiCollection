<?php

namespace App\Http\Controllers;

use App\ViewModels\AgeViewModel;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response as HttpResponseCodes;

class BrandCtl extends Controller
{

    public function save(Request $request)
    {
        $file_name = $request->brandImage->getClientOriginalName();
        return $file_name;
    }

}
