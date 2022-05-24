<?php

namespace App\UseCases;

use App\Repositories\AddressRepository;
use App\Repositories\SupplierRepository;
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

    public function gerIndexData(SupplierViewModel $supplierViewModel){
        $suppliers = $this->supplierRepository->read();

    }

}
