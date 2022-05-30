<?php

namespace App\UseCases;

use App\Enums\AddressType;
use App\Enums\CustomResponseCode;
use App\Enums\CustomResponseMsg;
use App\Models\CustomResponse;
use App\Repositories\AddressRepository;
use App\Repositories\SupplierRepository;
use App\ViewModels\AddressViewModel;
use App\ViewModels\SupplierViewModel;

class SupplierUseCase extends BaseUseCase
{
    public AddressRepository $addressRepository;
    public SupplierRepository $supplierRepository;

    public function __construct(AddressRepository $addressRepository,SupplierRepository $supplierRepository)
    {
        $this->addressRepository = $addressRepository;
        $this->supplierRepository = $supplierRepository;
    }

    public function getIndexData(SupplierViewModel $supplierViewModel) : CustomResponse
    {

        $customResponse = new CustomResponse();

        $suppliers = [];
        $rSuppliers = $this->supplierRepository->read();

        foreach ($rSuppliers as $rSupplier){
            $supplier["id"] = $rSupplier->id;
            $supplier["supplierName"] = $rSupplier->supplierName;
            $rAddresses = $this->addressRepository->readByLinkUpIdAndType($rSupplier->id,AddressType::SUPPLIER->name);
            $supplier["addresses"] = $rAddresses;
            $suppliers[] = $supplier;
        }

        $customResponse->setSuppliers($suppliers);
        $customResponse->setCode(CustomResponseCode::SUCCESS->value);
        $customResponse->setMsg(CustomResponseMsg::SUCCESS->value);
        return $customResponse;
    }

    public function save(SupplierViewModel $supplierViewModel) : CustomResponse
    {
        $existSupplierResponse = $this->supplierRepository->isSupplierExist($supplierViewModel);
        $existAddressResponse = $this->addressRepository->isAddressExist($supplierViewModel->getAddressViewModel());

        if($existSupplierResponse->getCode() == CustomResponseCode::ERROR->value
            && $existAddressResponse->getCode() == CustomResponseCode::ERROR->value){
            return $existSupplierResponse;
        }else{
            $supplierSaveRes = $this->supplierRepository->create($supplierViewModel);
            if ($supplierSaveRes->getCode() == CustomResponseCode::SUCCESS->value){
                $supplierViewModel->getAddressViewModel()->setLinkUpId($supplierSaveRes->getModel()->id);
                $addressSaveRes = $this->addressRepository->create($supplierViewModel->getAddressViewModel());
                $supplierSaveRes->setAddress($addressSaveRes->getModel());
            }else{
                $supplierSaveRes->setMsg(CustomResponseMsg::ERROR->value);
                $supplierSaveRes->setCode(CustomResponseCode::ERROR->value);
            }
            return $supplierSaveRes;
        }
    }

    public function update(SupplierViewModel $supplierViewModel) : CustomResponse
    {
        $supplierUpdateResponse = $this->supplierRepository->update($supplierViewModel);

        if ($supplierUpdateResponse->getCode() == CustomResponseCode::SUCCESS->value){
            $this->addressRepository->update($supplierViewModel->getAddressViewModel());
        }else{
            $supplierUpdateResponse->setCode(CustomResponseCode::ERROR->value);
            $supplierUpdateResponse->setMsg(CustomResponseMsg::ERROR->value);
        }
        return $supplierUpdateResponse;
    }

    public function remove(SupplierViewModel $supplierViewModel) : CustomResponse
    {
        return $this->supplierRepository->delete($supplierViewModel);
    }

}
