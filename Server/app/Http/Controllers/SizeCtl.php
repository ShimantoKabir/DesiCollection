<?php

namespace App\Http\Controllers;

use App\ViewModels\SizeViewModel;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response as HttpResponseCodes;

class SizeCtl extends Controller
{
    public SizeViewModel $sizeViewModel;

    public function __construct(SizeViewModel $sizeViewModel)
    {
        $this->sizeViewModel = $sizeViewModel;
    }

    public function index(Request $request): JsonResponse
    {
        return response()->json($this->sizeViewModel->getIndexData($request), HttpResponseCodes::HTTP_OK);
    }

    public function save(Request $request) : JsonResponse
    {
        return response()->json($this->sizeViewModel->save($request), HttpResponseCodes::HTTP_OK);
    }

    public function update(Request $request) : JsonResponse
    {
        return response()->json($this->sizeViewModel->update($request), HttpResponseCodes::HTTP_OK);
    }

    public function remove(Request $request) : JsonResponse
    {
        return response()->json($this->sizeViewModel->remove($request), HttpResponseCodes::HTTP_OK);
    }
}
