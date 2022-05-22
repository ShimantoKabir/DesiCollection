<?php

namespace App\Repositories\Interfaces;

use App\Models\CustomResponse;
use App\ViewModels\ColorViewModel;

interface IColorRepository extends IBaseRepository
{
    public function getIndexData() : CustomResponse;
    public function create(ColorViewModel $colorViewModel) : CustomResponse;
    public function update(ColorViewModel $colorViewModel) : CustomResponse;
    public function delete(ColorViewModel $colorViewModel) : CustomResponse;
}
