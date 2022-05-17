<?php

namespace App\UseCases;

use App\Enums\CustomResponseCode;
use App\Models\CustomResponse;
use App\Repositories\ProductUserTypeRepository;
use App\ViewModels\ProductUserTypeViewModel;

class ProductUserTypeUseCase extends BaseUseCase
{
    private ProductUserTypeRepository $productUsertypeRepository;

    public function __construct(ProductUserTypeRepository $productUsertypeRepository)
    {
        $this->productUsertypeRepository = $productUsertypeRepository;
    }

    public function getIndexData() : CustomResponse
    {
        return $this->productUsertypeRepository->getIndexData();
    }

    public function save(ProductUserTypeViewModel $productUserTypeViewModel) : CustomResponse
    {
        $existResponse = $this->productUsertypeRepository->isUserTypeExist($productUserTypeViewModel);

        if($existResponse->code == CustomResponseCode::ERROR->value){
            return $existResponse;
        }else{
            return $this->productUsertypeRepository->create($productUserTypeViewModel);
        }
    }

    public function update(ProductUserTypeViewModel $productUserTypeViewModel) : CustomResponse
    {
        $existResponse = $this->productUsertypeRepository->isUserTypeExist($productUserTypeViewModel);

        if($existResponse->code == CustomResponseCode::ERROR->value){
            return $existResponse;
        }else{
            return $this->productUsertypeRepository->update($productUserTypeViewModel);
        }
    }

    public function remove(ProductUserTypeViewModel $productUserTypeViewModel) : CustomResponse
    {
        return $this->productUsertypeRepository->delete($productUserTypeViewModel);
    }
}
