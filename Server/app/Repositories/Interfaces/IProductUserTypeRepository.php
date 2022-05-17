<?php

namespace App\Repositories\Interfaces;

use App\Models\CustomResponse;
use App\ViewModels\ProductUserTypeViewModel;

interface IProductUserTypeRepository extends IBaseRepository
{
    public function getIndexData() : CustomResponse;
    public function create(ProductUserTypeViewModel $productUserTypeViewModel) : CustomResponse;
    public function update(ProductUserTypeViewModel $productUserTypeViewModel) : CustomResponse;
    public function delete(ProductUserTypeViewModel $productUserTypeViewModel) : CustomResponse;
    public function isUserTypeExist(ProductUserTypeViewModel $productUserTypeViewModel) : CustomResponse;
}
