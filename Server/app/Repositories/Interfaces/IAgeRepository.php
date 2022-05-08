<?php

namespace App\Repositories\Interfaces;

use App\Models\CustomResponse;
use App\ViewModels\AgeViewModel;

interface IAgeRepository extends IBaseRepository
{
    public function getIndexData() : CustomResponse;
    public function create(AgeViewModel $ageViewModel) : CustomResponse;
    public function update(AgeViewModel $ageViewModel) : CustomResponse;
    public function delete(AgeViewModel $ageViewModel) : CustomResponse;
    public function isAgeExist(int $minAge, int $maxAge, int $fixedAge) : CustomResponse;
}
