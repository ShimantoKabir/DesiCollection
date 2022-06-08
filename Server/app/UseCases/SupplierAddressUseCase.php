<?php

namespace App\UseCases;

use App\Enums\CustomResponseCode;
use App\Models\CustomResponse;
use App\Repositories\AddressRepository;
use App\Repositories\SupplierAddressRepository;
use App\Repositories\SupplierRepository;
use App\ViewModels\SupplierAddressViewModel;

class SupplierAddressUseCase extends BaseUseCase
{
    public SupplierAddressRepository $supplierAddressRepository;
    public SupplierRepository $supplierRepository;

    public function __construct(SupplierAddressRepository $supplierAddressRepository,
                                SupplierRepository $supplierRepository)
    {
        $this->supplierAddressRepository = $supplierAddressRepository;
        $this->supplierRepository = $supplierRepository;
    }

    public function getIndexData(SupplierAddressViewModel $supplierAddressViewModel) : CustomResponse
    {
        $indexData =  $this->supplierAddressRepository->getIndexData($supplierAddressViewModel);
        $indexData->setSuppliers($this->supplierRepository->read());
        return $indexData;
    }

    public function save(SupplierAddressViewModel $supplierAddressViewModel) : CustomResponse
    {
        $existResponse = $this->supplierAddressRepository->isSupplierAddressExist($supplierAddressViewModel);

        if($existResponse->code == CustomResponseCode::ERROR->value){
            return $existResponse;
        }else{
            return $this->supplierAddressRepository->create($supplierAddressViewModel);
        }
    }

    public function update(SupplierAddressViewModel $supplierAddressViewModel) : CustomResponse
    {
        return $this->supplierAddressRepository->update($supplierAddressViewModel);
    }

    public function remove(SupplierAddressViewModel $supplierAddressViewModel) : CustomResponse
    {
        return $this->supplierAddressRepository->delete($supplierAddressViewModel);
    }

}
