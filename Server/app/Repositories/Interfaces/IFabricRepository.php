<?php

namespace App\Repositories\Interfaces;

use App\Models\CustomRequest;
use App\Models\CustomResponse;
use App\ViewModels\FabricViewModel;

interface IFabricRepository extends IBaseRepository
{

    public function getIndexData() : CustomResponse;
    public function create(FabricViewModel $fabricViewModel) : CustomResponse;
    public function read(FabricViewModel $fabricViewModel) : CustomResponse;
    public function update(FabricViewModel $fabricViewModel) : CustomResponse;
    public function delete(FabricViewModel $fabricViewModel) : CustomResponse;

}
