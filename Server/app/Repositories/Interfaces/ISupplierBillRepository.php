<?php

namespace App\Repositories\Interfaces;

use App\Models\CustomResponse;
use App\ViewModels\SupplierBillViewModel;

interface ISupplierBillRepository extends IBaseRepository
{
    public function getIndexData() : CustomResponse;
    public function create(SupplierBillViewModel $supplierBillViewModel) : CustomResponse;
    public function update(SupplierBillViewModel $supplierBillViewModel) : CustomResponse;
    public function delete(SupplierBillViewModel $supplierBillViewModel) : CustomResponse;
    public function isSupplierBillExist(SupplierBillViewModel $supplierBillViewModel) : CustomResponse;
}
