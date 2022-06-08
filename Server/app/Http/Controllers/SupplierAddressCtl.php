<?php

namespace App\Http\Controllers;

use App\ViewModels\SupplierAddressViewModel;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response as HttpResponseCodes;
use Illuminate\Http\JsonResponse;

class SupplierAddressCtl extends Controller
{
    public SupplierAddressViewModel $supplierAddressViewModel;

    public function __construct(Request $request,SupplierAddressViewModel $supplierAddressViewModel)
    {
        $this->supplierAddressViewModel = $supplierAddressViewModel;
    }

    public function index(Request $request): JsonResponse
    {
        return response()->json($this->supplierAddressViewModel->getIndexData($request), HttpResponseCodes::HTTP_OK);
    }

    public function save(Request $request) : JsonResponse
    {
        return response()->json($this->supplierAddressViewModel->save($request), HttpResponseCodes::HTTP_OK);
    }

    public function update(Request $request) : JsonResponse
    {
        return response()->json($this->supplierAddressViewModel->update($request), HttpResponseCodes::HTTP_OK);
    }

    public function remove(Request $request) : JsonResponse
    {
        return response()->json($this->supplierAddressViewModel->remove($request), HttpResponseCodes::HTTP_OK);
    }
}
