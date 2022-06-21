<?php

namespace App\Http\Controllers;

use App\Models\CustomResponse;
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
        // return $request->file("productImages")[0]->getClientOriginalExtension();

        return response()->json($this->productViewModel->save($request), HttpResponseCodes::HTTP_OK);
    }
}
