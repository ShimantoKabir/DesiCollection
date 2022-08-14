<?php

namespace App\Repositories\Interfaces;

use App\Models\CustomResponse;
use App\ViewModels\BillViewModel;

interface IBillRepository extends IBaseRepository
{
    public function getIndexData() : CustomResponse;
    public function create(BillViewModel $billViewModel) : CustomResponse;
    public function update(BillViewModel $billViewModel) : CustomResponse;
}
