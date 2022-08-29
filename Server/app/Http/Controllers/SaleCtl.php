<?php

namespace App\Http\Controllers;

use App\ViewModels\SaleViewModel;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response as HttpResponseCodes;

class SaleCtl extends Controller
{
    private SaleViewModel $saleViewModel;

    public function __construct(SaleViewModel $saleViewModel)
    {
        $this->saleViewModel = $saleViewModel;
    }

    public function getSalesByBillNumber(Request $request): JsonResponse
    {
        return response()->json($this->saleViewModel->getSalesByBillNumber($request), HttpResponseCodes::HTTP_OK);
    }
}
