<?php

namespace App\Repositories\Interfaces;

use App\Models\CustomResponse;
use App\ViewModels\BrandViewModel;

interface IBrandRepository extends IBaseRepository
{
    public function getIndexData() : CustomResponse;
    public function create(BrandViewModel $brandViewModel) : CustomResponse;
    public function update(BrandViewModel $brandViewModel) : CustomResponse;
    public function delete(BrandViewModel $brandViewModel) : CustomResponse;
    public function isBrandExist(BrandViewModel $brandViewModel) : CustomResponse;
}
