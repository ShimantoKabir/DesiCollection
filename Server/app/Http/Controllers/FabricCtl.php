<?php

namespace App\Http\Controllers;

use App\ViewModels\FabricViewModel;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response as HttpResponseCodes;

class FabricCtl extends Controller
{

    public FabricViewModel $fabricViewModel;

    public function __construct(Request $request,FabricViewModel $fabricViewModel)
    {
        $this->fabricViewModel = $fabricViewModel;
    }

    public function index(Request $request): JsonResponse
    {
        return response()->json($this->fabricViewModel->getIndexData($request), HttpResponseCodes::HTTP_OK);
    }

    public function save(Request $request) : JsonResponse
    {
        return response()->json($this->fabricViewModel->save($request), HttpResponseCodes::HTTP_OK);
    }

    public function update(Request $request) : JsonResponse
    {
        return response()->json($this->fabricViewModel->update($request), HttpResponseCodes::HTTP_OK);
    }

    public function remove(Request $request) : JsonResponse
    {
        return response()->json($this->fabricViewModel->remove($request), HttpResponseCodes::HTTP_OK);
    }

}
