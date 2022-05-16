<?php

namespace App\Repositories;

use App\Enums\CustomResponseCode;
use App\Enums\CustomResponseMsg;
use App\Models\CustomResponse;
use App\Models\ProductType;
use App\Repositories\Interfaces\ITypeRepository;
use App\ViewModels\TypeViewModel;
use Illuminate\Support\Facades\DB;

class TypeRepository extends BaseRepository implements ITypeRepository
{

    public function read(): array
    {
        return ProductType::select("id","typeName")->get()->toArray();
    }

    public function getIndexData(): CustomResponse
    {
        $res = new CustomResponse();
        $res->setCode(CustomResponseCode::SUCCESS->value);
        $res->setMsg(CustomResponseMsg::INIT_SUCCESS->value);
        $res->setTypes($this->read());
        return $res;
    }

    public function create(TypeViewModel $typeViewModel): CustomResponse
    {
        $date = $this->getCurrentDate();
        $res = new CustomResponse();
        DB::beginTransaction();
        try{

            $model = new ProductType();
            $model->typeName = $typeViewModel->getTypeName();
            $model->ip = $typeViewModel->getIp();
            $model->modifiedBy = $typeViewModel->getModifiedBy();
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

    public function update(TypeViewModel $typeViewModel): CustomResponse
    {
        $date = $this->getCurrentDate();
        $res = new CustomResponse();
        DB::beginTransaction();
        try{

            ProductType::where('id',$typeViewModel->getId())
                ->update([
                    'typeName' => $typeViewModel->getTypeName(),
                    'updatedAt' => $date
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

    public function delete(TypeViewModel $typeViewModel): CustomResponse
    {
        $res = new CustomResponse();
        DB::beginTransaction();
        try{

            ProductType::where('id',$typeViewModel->id)->delete();
            DB::commit();

            $res->setCode(CustomResponseCode::SUCCESS->value);
            $res->setMsg(CustomResponseMsg::SUCCESS->value);

        }catch (\Exception $e){
            $res->setCode(CustomResponseCode::ERROR->value);
            $res->setMsg($e->getMessage());
        }

        return $res;
    }

    public function isTypeExist(TypeViewModel $typeViewModel): CustomResponse
    {
        $res = new CustomResponse();
        $isExist = ProductType::where('typeName',$typeViewModel->getTypeName())->exists();

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
