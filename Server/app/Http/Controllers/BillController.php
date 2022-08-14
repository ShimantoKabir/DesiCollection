<?php

namespace App\Http\Controllers;

use App\ViewModels\BillViewModel;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response as HttpResponseCodes;

class BillController extends Controller
{

    public BillViewModel $billViewModel;

    public function __construct(BillViewModel $billViewModel)
    {
        $this->billViewModel = $billViewModel;
    }

    public function index(Request $request): JsonResponse
    {
        return response()->json($this->billViewModel->getIndexData($request), HttpResponseCodes::HTTP_OK);
    }

}