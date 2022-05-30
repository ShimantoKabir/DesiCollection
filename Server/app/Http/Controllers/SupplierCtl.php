<?php

namespace App\Http\Controllers;

use App\ViewModels\SupplierViewModel;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response as HttpResponseCodes;

class SupplierCtl extends Controller
{

    public SupplierViewModel $supplierViewModel;

    public function __construct(SupplierViewModel $supplierViewModel)
    {
        $this->supplierViewModel = $supplierViewModel;
    }

    public function index(Request $request): JsonResponse
    {
        return response()->json($this->supplierViewModel->getIndexData($request), HttpResponseCodes::HTTP_OK);
    }

    public function save(Request $request) : JsonResponse
    {
        return response()->json($this->supplierViewModel->save($request), HttpResponseCodes::HTTP_OK);
    }

    public function update(Request $request) : JsonResponse
    {
        return response()->json($this->supplierViewModel->update($request), HttpResponseCodes::HTTP_OK);
    }

    public function remove(Request $request) : JsonResponse
    {
        return response()->json($this->supplierViewModel->remove($request), HttpResponseCodes::HTTP_OK);
    }


}
