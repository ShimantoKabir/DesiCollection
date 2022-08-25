<?php

namespace App\Repositories;

use App\Enums\CustomResponseCode;
use App\Enums\CustomResponseMsg;
use App\Enums\OperationType;
use App\Enums\UserType;
use App\Models\CustomResponse;
use App\Models\Sale;
use App\Models\UserInfo;
use App\Repositories\Interfaces\ISaleRepository;
use Illuminate\Support\Facades\DB;

class SaleRepository extends BaseRepository implements ISaleRepository
{

    public function read(): array
    {
        return [];
    }

    public function createMultiple(array $saleViewModes): CustomResponse
    {
        $response = new CustomResponse();

        DB::beginTransaction();
        try {

            foreach ($saleViewModes as $sale){
                $s = new Sale();
                $s->billNumber = $sale["billNumber"];
                $s->singlePrice = $sale["singlePrice"];
                $s->vatPercentage = $sale["vatPercentage"];
                $s->productCode = $sale["productCode"];
                $s->productQuantity = $sale["productQuantity"];
                $s->ip = $sale["ip"];
                $s->createdAt = $sale["createdAt"];
                $s->modifiedBy = $sale["modifiedBy"];
                $s->save();
                DB::commit();
            }

            $response->setMsg(CustomResponseMsg::SUCCESS->value);
            $response->setCode(CustomResponseCode::SUCCESS->value);

        }catch (\Exception $e){
            DB::rollBack();
            $response->setMsg($e->getMessage());
            $response->setCode(CustomResponseCode::ERROR->value);
        }

        return $response;
    }
}
