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

    public function calculate(Request $request): JsonResponse
    {
        return response()->json($this->billViewModel->calculate($request), HttpResponseCodes::HTTP_OK);
    }

    public function save(Request $request): JsonResponse
    {
        return response()->json($this->billViewModel->save($request), HttpResponseCodes::HTTP_OK);
    }

    public function getBills(Request $request): JsonResponse
    {
        return response()->json($this->billViewModel->getBills($request), HttpResponseCodes::HTTP_OK);
    }
}
