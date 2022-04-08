<?php

namespace App\UseCases;

use App\Models\CustomResponse;
use App\Models\ProductColor;
use App\Repositories\FabricRepository;
use Illuminate\Http\Request;

class FabricUseCase extends BaseUseCase
{

    public function getIndexData(Request $request) : CustomResponse
    {
        return $this->fabricRepository->getIndexData($request);
    }
}
