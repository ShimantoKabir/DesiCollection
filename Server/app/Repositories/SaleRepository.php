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
use App\ViewModels\SaleViewModel;
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

    public function getSalesByBillNumber(SaleViewModel $saleViewModel) : CustomResponse
    {
        $res = new CustomResponse();

        $saleRecords = Sale::query()->select("singlePrice","vatPercentage","productCode","productQuantity")
            ->where("billNumber",$saleViewModel->getBillNumber())
            ->get()->toArray();

        if (count($saleRecords) > 0){
            foreach ($saleRecords as $index=>$value){
                $total = $this->totalCalculationWithVat($value);
                $saleRecords[$index]["total"] = $total;
            }
            $res->setSaleViewModels($saleRecords);
            $res->setCode(CustomResponseCode::SUCCESS->value);
            $res->setMsg(CustomResponseMsg::SUCCESS->value);
        }else{
            $res->setCode(CustomResponseCode::ERROR->value);
            $res->setMsg(CustomResponseMsg::ERROR->value);
        }

        return $res;
    }

    private function totalCalculationWithVat(mixed $value) : int
    {
        $priceWithVat = $value["singlePrice"] * ($value["vatPercentage"]/100);
        $totalVat = $value["productQuantity"] * round($priceWithVat);
        $totalPrice = $value["productQuantity"] * $value["singlePrice"];
        return $totalVat + $totalPrice;
    }

}
