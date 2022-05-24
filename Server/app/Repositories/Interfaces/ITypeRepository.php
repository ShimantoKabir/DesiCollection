<?php

namespace App\Repositories\Interfaces;

use App\Models\CustomResponse;
use App\ViewModels\SupplierViewModel;
use App\ViewModels\TypeViewModel;

interface ITypeRepository extends IBaseRepository
{
    public function getIndexData() : CustomResponse;
    public function create(TypeViewModel $typeViewModel) : CustomResponse;
    public function update(TypeViewModel $typeViewModel) : CustomResponse;
    public function delete(TypeViewModel $typeViewModel) : CustomResponse;
    public function isTypeExist(TypeViewModel $typeViewModel) : CustomResponse;
}
