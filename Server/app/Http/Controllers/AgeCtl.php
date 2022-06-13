<?php

namespace App\Http\Controllers;

use App\ViewModels\AgeViewModel;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response as HttpResponseCodes;

class AgeCtl extends Controller
{
    public AgeViewModel $ageViewModel;

    public function __construct(AgeViewModel $ageViewModel)
    {
        $this->ageViewModel = $ageViewModel;
    }

    public function index(Request $request): JsonResponse
    {
        return response()->json($this->ageViewModel->getIndexData($request), HttpResponseCodes::HTTP_OK);
    }

    public function save(Request $request) : JsonResponse
    {
        return response()->json($this->ageViewModel->save($request), HttpResponseCodes::HTTP_OK);
    }

    public function update(Request $request) : JsonResponse
    {
        return response()->json($this->ageViewModel->update($request), HttpResponseCodes::HTTP_OK);
    }

    public function remove(Request $request) : JsonResponse
    {
        return response()->json($this->ageViewModel->remove($request), HttpResponseCodes::HTTP_OK);
    }
}
