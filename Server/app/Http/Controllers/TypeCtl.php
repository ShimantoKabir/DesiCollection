<?php

namespace App\Http\Controllers;

use App\ViewModels\TypeViewModel;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response as HttpResponseCodes;

class TypeCtl extends Controller
{
    public TypeViewModel $typeViewModel;

    public function __construct(Request $request,TypeViewModel $typeViewModel)
    {
        $this->typeViewModel = $typeViewModel;
    }

    public function index(Request $request): JsonResponse
    {
        return response()->json($this->typeViewModel->getIndexData($request), HttpResponseCodes::HTTP_OK);
    }

    public function save(Request $request) : JsonResponse
    {
        return response()->json($this->typeViewModel->save($request), HttpResponseCodes::HTTP_OK);
    }

    public function update(Request $request) : JsonResponse
    {
        return response()->json($this->typeViewModel->update($request), HttpResponseCodes::HTTP_OK);
    }

    public function remove(Request $request) : JsonResponse
    {
        return response()->json($this->typeViewModel->remove($request), HttpResponseCodes::HTTP_OK);
    }
}
