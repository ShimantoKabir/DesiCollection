<?php

namespace App\Http\Controllers;

use App\ViewModels\TypeViewModel;
use App\ViewModels\ProductUserTypeViewModel;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response as HttpResponseCodes;

class ProductUserTypeCtl extends Controller
{
    public ProductUserTypeViewModel $productUserTypeViewModel;

    public function __construct(ProductUserTypeViewModel $productUserTypeViewModel)
    {
        $this->productUserTypeViewModel = $productUserTypeViewModel;
    }

    public function index(Request $request): JsonResponse
    {
        return response()->json($this->productUserTypeViewModel->getIndexData($request), HttpResponseCodes::HTTP_OK);
    }

    public function save(Request $request) : JsonResponse
    {
        return response()->json($this->productUserTypeViewModel->save($request), HttpResponseCodes::HTTP_OK);
    }

    public function update(Request $request) : JsonResponse
    {
        return response()->json($this->productUserTypeViewModel->update($request), HttpResponseCodes::HTTP_OK);
    }

    public function remove(Request $request) : JsonResponse
    {
        return response()->json($this->productUserTypeViewModel->remove($request), HttpResponseCodes::HTTP_OK);
    }
}
