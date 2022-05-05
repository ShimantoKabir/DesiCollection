<?php

namespace App\UseCases;

use App\Enums\CustomResponseCode;
use App\Enums\CustomResponseMsg;
use App\Models\CustomRequest;
use App\Models\CustomResponse;
use App\Models\Fabric;
use App\Repositories\FabricRepository;
use App\ViewModels\FabricViewModel;
use JetBrains\PhpStorm\Pure;

class FabricUseCase extends BaseUseCase
{

    private FabricRepository $fabricRepository;

    #[Pure]
    public function __construct(
        CustomRequest $customRequest,
        CustomResponse $customResponse,
        FabricRepository $fabricRepository
    )
    {
        parent::__construct($customRequest, $customResponse);
        $this->fabricRepository = $fabricRepository;
    }

    public function getIndexData() : CustomResponse
    {
        return $this->fabricRepository->getIndexData();
    }

    public function save(FabricViewModel $fabricViewModel) : CustomResponse
    {
        $existResponse = $this->fabricRepository->isFabricNameExist($fabricViewModel->fabricName);

        if($existResponse->code == CustomResponseCode::ERROR->value){
            return $existResponse;
        }else{
            return $this->fabricRepository->create($fabricViewModel);
        }
    }

    public function update(FabricViewModel $fabricViewModel) : CustomResponse
    {
        $existResponse = $this->fabricRepository->isFabricNameExist($fabricViewModel->fabricName);

        if($existResponse->code == CustomResponseCode::ERROR->value){
            return $existResponse;
        }else{
            return $this->fabricRepository->update($fabricViewModel);
        }
    }

    public function remove(FabricViewModel $fabricViewModel) : CustomResponse
    {
        return $this->fabricRepository->delete($fabricViewModel);
    }

}
