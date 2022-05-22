<?php

namespace App\Repositories;

use App\Models\Color;
use App\Models\CustomResponse;
use App\ViewModels\ColorViewModel;

class ColorRepository extends BaseRepository implements Interfaces\IColorRepository
{

    public function read(): array
    {
        return Color::select("id","colorName")->get()->toArray();
    }

    public function getIndexData(): CustomResponse
    {
        // TODO: Implement getIndexData() method.
    }

    public function create(ColorViewModel $colorViewModel): CustomResponse
    {
        // TODO: Implement create() method.
    }

    public function update(ColorViewModel $colorViewModel): CustomResponse
    {
        // TODO: Implement update() method.
    }

    public function delete(ColorViewModel $colorViewModel): CustomResponse
    {
        // TODO: Implement delete() method.
    }
}
