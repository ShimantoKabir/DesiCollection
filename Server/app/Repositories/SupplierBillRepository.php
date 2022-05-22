<?php

namespace App\Repositories;

use App\Models\Size;
use App\Models\SupplierBill;

class SupplierBillRepository extends BaseRepository implements Interfaces\ISupplierBillRepository
{

    public function read(): array
    {
        return SupplierBill::select("id","billNumber")->get()->toArray();
    }
}
