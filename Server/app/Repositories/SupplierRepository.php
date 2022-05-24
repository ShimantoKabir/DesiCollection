<?php

namespace App\Repositories;

use App\Enums\CustomResponseCode;
use App\Enums\CustomResponseMsg;
use App\Models\Address;
use App\Models\CustomResponse;
use App\Models\ProductType;
use App\Models\Supplier;
use App\ViewModels\SupplierViewModel;
use Illuminate\Support\Facades\DB;

class SupplierRepository extends BaseRepository implements Interfaces\ISupplierRepository
{

    public function read(): array
    {
        return Supplier::select(
            'id',
            'supplierName',
        )->get()->toArray();
    }

    public function getIndexData(): CustomResponse
    {
        $res = new CustomResponse();
        $res->setCode(CustomResponseCode::SUCCESS->value);
        $res->setMsg(CustomResponseMsg::INIT_SUCCESS->value);
        $res->setTypes($this->read());
        return $res;
    }

    public function create(SupplierViewModel $supplierViewModel): CustomResponse
    {
        $date = $this->getCurrentDate();
        $res = new CustomResponse();
        DB::beginTransaction();
        try{

            $model = new Supplier();
            $model->supplierName = $supplierViewModel->getSupplierName();
            $model->ip = $supplierViewModel->getIp();
            $model->modifiedBy = $supplierViewModel->getModifiedBy();
            $model->createdAt = $date;
            $model->save();

            $res->setModel($model);
            $res->setCode(CustomResponseCode::SUCCESS->value);
            $res->setMsg(CustomResponseMsg::SUCCESS->value);

            DB::commit();

        }catch (\Exception $e){
            $res->setCode(CustomResponseCode::ERROR->value);
            $res->setMsg($e->getMessage());
        }

        return $res;
    }

    public function update(SupplierViewModel $supplierViewModel): CustomResponse
    {
        $date = $this->getCurrentDate();
        $res = new CustomResponse();
        DB::beginTransaction();
        try{

            Supplier::where('id',$supplierViewModel->getId())
                ->update([
                    'supplierName' => $supplierViewModel->getSupplierName(),
                    'updatedAt' => $date,
                    'modifiedBy' => $supplierViewModel->getModifiedBy()
                ]);

            DB::commit();
            $res->setCode(CustomResponseCode::SUCCESS->value);
            $res->setMsg(CustomResponseMsg::SUCCESS->value);

        }catch (\Exception $e){
            $res->setCode(CustomResponseCode::ERROR->value);
            $res->setMsg($e->getMessage());
        }

        return $res;
    }

    public function delete(SupplierViewModel $supplierViewModel): CustomResponse
    {
        $res = new CustomResponse();
        DB::beginTransaction();
        try{

            Supplier::where('id',$supplierViewModel->getId())->delete();
            DB::commit();

            $res->setCode(CustomResponseCode::SUCCESS->value);
            $res->setMsg(CustomResponseMsg::SUCCESS->value);

        }catch (\Exception $e){
            $res->setCode(CustomResponseCode::ERROR->value);
            $res->setMsg($e->getMessage());
        }

        return $res;
    }

    public function isSupplierExist(SupplierViewModel $supplierViewModel): CustomResponse
    {
        $res = new CustomResponse();
        $isExist = Supplier::where('supplierName',$supplierViewModel->getSupplierName())->exists();

        if($isExist){
            $res->setCode(CustomResponseCode::ERROR->value);
            $res->setMsg(CustomResponseMsg::SIZE_NAME_EXIST->value);
        }else{
            $res->setCode(CustomResponseCode::SUCCESS->value);
            $res->setMsg(CustomResponseMsg::SUCCESS->value);
        }

        return $res;
    }
}
