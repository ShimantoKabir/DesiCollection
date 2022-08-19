<?php

namespace App\Repositories\Interfaces;

use App\Models\CustomResponse;
use App\ViewModels\ProductViewModel;

interface IProductRepository extends IBaseRepository
{
    public function getIndexData(ProductViewModel $productViewModel) : CustomResponse;
    public function create(ProductViewModel $productViewModel) : CustomResponse;
    public function update(ProductViewModel $productViewModel) : CustomResponse;
    public function delete(ProductViewModel $productViewModel) : CustomResponse;
    public function isProductExist(ProductViewModel $productViewModel) : CustomResponse;
    public function readProduct(ProductViewModel $productViewModel): array;
    public function getProductDetailsByCode(string $code): CustomResponse;
}
