<?php

namespace App\Http\Controllers;

use App\ViewModels\BrandViewModel;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response as HttpResponseCodes;

class BrandCtl extends Controller
{

    public BrandViewModel $brandViewModel;

    public function __construct(Request $request,BrandViewModel $brandViewModel)
    {
        $this->brandViewModel = $brandViewModel;
    }

    public function index(Request $request): JsonResponse
    {
        return response()->json($this->brandViewModel->getIndexData($request), HttpResponseCodes::HTTP_OK);
    }

    public function save(Request $request) : JsonResponse
    {
        return response()->json($this->brandViewModel->save($request), HttpResponseCodes::HTTP_OK);
    }

    public function update(Request $request) : JsonResponse
    {
        return response()->json($this->brandViewModel->update($request), HttpResponseCodes::HTTP_OK);
    }

    public function remove(Request $request) : JsonResponse
    {
        return response()->json($this->brandViewModel->remove($request), HttpResponseCodes::HTTP_OK);
    }

}
