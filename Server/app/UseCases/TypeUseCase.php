<?php

namespace App\UseCases;

use App\Enums\CustomResponseCode;
use App\Models\CustomResponse;
use App\Repositories\TypeRepository;
use App\ViewModels\TypeViewModel;

class TypeUseCase extends BaseUseCase
{
    private TypeRepository $typeRepository;

    public function __construct(TypeRepository $typeRepository)
    {
        $this->typeRepository = $typeRepository;
    }

    public function getIndexData() : CustomResponse
    {
        return $this->typeRepository->getIndexData();
    }

    public function save(TypeViewModel $typeViewModel) : CustomResponse
    {
        $existResponse = $this->typeRepository->isTypeExist($typeViewModel);

        if($existResponse->code == CustomResponseCode::ERROR->value){
            return $existResponse;
        }else{
            return $this->typeRepository->create($typeViewModel);
        }
    }

    public function update(TypeViewModel $typeViewModel) : CustomResponse
    {
        $existResponse = $this->typeRepository->isTypeExist($typeViewModel);

        if($existResponse->code == CustomResponseCode::ERROR->value){
            return $existResponse;
        }else{
            return $this->typeRepository->update($typeViewModel);
        }
    }

    public function remove(TypeViewModel $typeViewModel) : CustomResponse
    {
        return $this->typeRepository->delete($typeViewModel);
    }
}
