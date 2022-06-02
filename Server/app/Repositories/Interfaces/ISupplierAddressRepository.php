<?php

namespace App\Repositories\Interfaces;

use App\Models\CustomResponse;
use App\ViewModels\SupplierAddressViewModel;

interface ISupplierAddressRepository extends IBaseRepository
{
    public function getIndexData(SupplierAddressViewModel $supplierAddressViewModel) : CustomResponse;
    public function create(SupplierAddressViewModel $supplierAddressViewModel) : CustomResponse;
    public function update(SupplierAddressViewModel $supplierAddressViewModel) : CustomResponse;
    public function delete(SupplierAddressViewModel $supplierAddressViewModel) : CustomResponse;
    public function isSupplierAddressExist(SupplierAddressViewModel $supplierAddressViewModel) : CustomResponse;
}
