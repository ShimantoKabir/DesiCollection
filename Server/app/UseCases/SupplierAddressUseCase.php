<?php

namespace App\UseCases;

use App\Enums\CustomResponseCode;
use App\Models\CustomResponse;
use App\Repositories\AddressRepository;
use App\Repositories\SupplierAddressRepository;
use App\ViewModels\SupplierAddressViewModel;

class SupplierAddressUseCase extends BaseUseCase
{
    public SupplierAddressRepository $supplierAddressRepository;
    public AddressRepository $addressRepository;

    public function __construct(SupplierAddressRepository $supplierAddressRepository,AddressRepository $addressRepository)
    {
        $this->supplierAddressRepository = $supplierAddressRepository;
        $this->addressRepository = $addressRepository;
    }

    public function getIndexData(SupplierAddressViewModel $supplierAddressViewModel) : CustomResponse
    {
        return $this->supplierAddressRepository->getIndexData($supplierAddressViewModel);
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
        $existResponse = $this->supplierAddressRepository->isSupplierAddressExist($supplierAddressViewModel);

        if($existResponse->code == CustomResponseCode::ERROR->value){
            return $existResponse;
        }else{
            return $this->supplierAddressRepository->update($supplierAddressViewModel);
        }
    }

    public function remove(SupplierAddressViewModel $supplierAddressViewModel) : CustomResponse
    {
        return $this->supplierAddressRepository->delete($supplierAddressViewModel);
    }

}
