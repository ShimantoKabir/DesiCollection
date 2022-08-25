<?php

namespace App\Repositories\Interfaces;

use App\Models\CustomResponse;
use App\ViewModels\AddressViewModel;

interface ISaleRepository extends IBaseRepository
{
    public function createMultiple(array $saleViewModes) : CustomResponse;
}
