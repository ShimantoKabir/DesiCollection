<?php

namespace App\Repositories\Interfaces;

use App\Models\CustomResponse;
use App\ViewModels\SizeViewModel;

interface ISizeRepository extends IBaseRepository
{

    public function getIndexData() : CustomResponse;
    public function create(SizeViewModel $sizeViewModel) : CustomResponse;
    public function update(SizeViewModel $sizeViewModel) : CustomResponse;
    public function delete(SizeViewModel $sizeViewModel) : CustomResponse;

}
