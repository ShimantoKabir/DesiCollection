<?php

namespace App\Repositories\Interfaces;

use App\Models\CustomResponse;
use App\ViewModels\SupplierViewModel;

interface ISupplierRepository extends IBaseRepository
{
    public function getIndexData() : CustomResponse;
    public function create(SupplierViewModel $supplierViewModel) : CustomResponse;
    public function update(SupplierViewModel $supplierViewModel) : CustomResponse;
    public function delete(SupplierViewModel $supplierViewModel) : CustomResponse;
    public function isSupplierExist(SupplierViewModel $supplierViewModel) : CustomResponse;
}
