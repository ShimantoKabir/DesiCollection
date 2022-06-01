<?php

namespace App\UseCases;

use App\Enums\CustomResponseCode;
use App\Models\CustomResponse;
use App\Repositories\SupplierRepository;
use App\ViewModels\SupplierViewModel;

class SupplierUseCase extends BaseUseCase
{
    public SupplierRepository $supplierRepository;

    public function __construct(SupplierRepository $supplierRepository)
    {
        $this->supplierRepository = $supplierRepository;
    }

    public function getIndexData(SupplierViewModel $supplierViewModel) : CustomResponse
    {
        return $this->supplierRepository->getIndexData();
    }

    public function save(SupplierViewModel $supplierViewModel) : CustomResponse
    {
        $existResponse = $this->supplierRepository->isSupplierExist($supplierViewModel);

        if($existResponse->code == CustomResponseCode::ERROR->value){
            return $existResponse;
        }else{
            return $this->supplierRepository->create($supplierViewModel);
        }
    }

    public function update(SupplierViewModel $supplierViewModel) : CustomResponse
    {
        $existResponse = $this->supplierRepository->isSupplierExist($supplierViewModel);

        if($existResponse->code == CustomResponseCode::ERROR->value){
            return $existResponse;
        }else{
            return $this->supplierRepository->update($supplierViewModel);
        }
    }

    public function remove(SupplierViewModel $supplierViewModel) : CustomResponse
    {
        return $this->supplierRepository->delete($supplierViewModel);
    }

}
