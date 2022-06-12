<?php

namespace App\Http\Controllers;

use App\ViewModels\SupplierBillViewModel;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response as HttpResponseCodes;

class SupplierBillCtl extends Controller
{
    public SupplierBillViewModel $supplierBillViewModel;

    public function __construct(SupplierBillViewModel $supplierBillViewModel)
    {
        $this->supplierBillViewModel = $supplierBillViewModel;
    }

    public function index(Request $request): JsonResponse
    {
        return response()->json($this->supplierBillViewModel->getIndexData($request), HttpResponseCodes::HTTP_OK);
    }

    public function save(Request $request) : JsonResponse
    {
        return response()->json($this->supplierBillViewModel->save($request), HttpResponseCodes::HTTP_OK);
    }

    public function update(Request $request) : JsonResponse
    {
        return response()->json($this->supplierBillViewModel->update($request), HttpResponseCodes::HTTP_OK);
    }

    public function remove(Request $request) : JsonResponse
    {
        return response()->json($this->supplierBillViewModel->remove($request), HttpResponseCodes::HTTP_OK);
    }
}
