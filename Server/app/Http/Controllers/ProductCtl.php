<?php

namespace App\Http\Controllers;

use App\ViewModels\ProductViewModel;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response as HttpResponseCodes;

class ProductCtl extends Controller
{
    private ProductViewModel $productViewModel;

    public function __construct(ProductViewModel $productViewModel)
    {
        $this->productViewModel = $productViewModel;
    }

    public function index(Request $request): JsonResponse
    {
        return response()->json($this->productViewModel->getIndexData($request), HttpResponseCodes::HTTP_OK);
    }

    public function save(Request $request): JsonResponse
    {
        return response()->json($this->productViewModel->save($request), HttpResponseCodes::HTTP_OK);
    }

    public function update(Request $request): JsonResponse
    {
        return response()->json($this->productViewModel->update($request), HttpResponseCodes::HTTP_OK);
    }

    public function remove(Request $request): JsonResponse
    {
        return response()->json($this->productViewModel->remove($request), HttpResponseCodes::HTTP_OK);
    }
}
