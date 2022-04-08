<?php

namespace App\Http\Controllers;

use App\Models\CustomResponse;
use App\UseCases\FabricUseCase;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class FabricCtl extends Controller
{

    public FabricUseCase $fabricUseCase;

    public function __construct(FabricUseCase $fabricUseCase)
    {
        $this->fabricUseCase = $fabricUseCase;
    }

    public function index(Request $request): JsonResponse
    {
        $administrationRes = self::modifyRequest($request,"R");

        if($administrationRes["code"] == 200){
            $networkResponse = $this->fabricUseCase->getIndexData(self::mergeRequest($request,$administrationRes));
        }else {
            $networkResponse = $administrationRes;
        }

        return response()->json($networkResponse, 200);
    }
}
