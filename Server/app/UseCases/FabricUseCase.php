<?php

namespace App\UseCases;

use App\Models\CustomRequest;
use App\Models\CustomResponse;

class FabricUseCase extends BaseUseCase
{
    public function getIndexData() : CustomResponse
    {
        return $this->fabricRepository->getIndexData();
    }

    public function save(CustomRequest $customRequest) : CustomResponse
    {
        return $this->fabricRepository->create($customRequest);

    }
}
