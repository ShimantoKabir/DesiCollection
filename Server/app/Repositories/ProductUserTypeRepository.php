<?php

namespace App\Repositories;

use App\Enums\CustomResponseCode;
use App\Enums\CustomResponseMsg;
use App\Models\CustomResponse;
use App\Models\ProductUserType;
use App\Repositories\Interfaces\IProductUserTypeRepository;
use App\ViewModels\ProductUserTypeViewModel;
use Illuminate\Support\Facades\DB;

class ProductUserTypeRepository extends BaseRepository implements IProductUserTypeRepository
{

    public function read(): array
    {
        return ProductUserType::select("id","userTypeName")->get()->toArray();
    }

    public function getIndexData(): CustomResponse
    {
        $res = new CustomResponse();
        $res->setCode(CustomResponseCode::SUCCESS->value);
        $res->setMsg(CustomResponseMsg::INIT_SUCCESS->value);
        $res->setUserTypes($this->read());
        return $res;
    }

    public function create(ProductUserTypeViewModel $productUserTypeViewModel): CustomResponse
    {
        $date = $this->getCurrentDate();
        $res = new CustomResponse();
        DB::beginTransaction();
        try{

            $model = new ProductUserType();
            $model->userTypeName = $productUserTypeViewModel->getUserTypeName();
            $model->ip = $productUserTypeViewModel->getIp();
            $model->modifiedBy = $productUserTypeViewModel->getModifiedBy();
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

    public function update(ProductUserTypeViewModel $productUserTypeViewModel): CustomResponse
    {
        $date = $this->getCurrentDate();
        $res = new CustomResponse();
        DB::beginTransaction();
        try{

            ProductUserType::where('id',$productUserTypeViewModel->getId())
                ->update([
                    'userTypeName' => $productUserTypeViewModel->getUserTypeName(),
                    'updatedAt' => $date,
                    'modifiedBy' => $productUserTypeViewModel->getModifiedBy(),
                    'ip' => $productUserTypeViewModel->getIp()
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

    public function delete(ProductUserTypeViewModel $productUserTypeViewModel): CustomResponse
    {
        $res = new CustomResponse();
        DB::beginTransaction();
        try{

            ProductUserType::where('id',$productUserTypeViewModel->getId())->delete();
            DB::commit();

            $res->setCode(CustomResponseCode::SUCCESS->value);
            $res->setMsg(CustomResponseMsg::SUCCESS->value);

        }catch (\Exception $e){
            $res->setCode(CustomResponseCode::ERROR->value);
            $res->setMsg($e->getMessage());
        }

        return $res;
    }

    public function isUserTypeExist(ProductUserTypeViewModel $productUserTypeViewModel): CustomResponse
    {
        $res = new CustomResponse();
        $isExist = ProductUserType::where('userTypeName',$productUserTypeViewModel->getUserTypeName())->exists();

        if($isExist){
            $res->setCode(CustomResponseCode::ERROR->value);
            $res->setMsg(CustomResponseMsg::PRODUCT_USER_EXIST->value);
        }else{
            $res->setCode(CustomResponseCode::SUCCESS->value);
            $res->setMsg(CustomResponseMsg::SUCCESS->value);
        }

        return $res;
    }
}
