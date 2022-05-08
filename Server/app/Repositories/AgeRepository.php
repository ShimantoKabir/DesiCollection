<?php

namespace App\Repositories;

use App\Enums\CustomResponseCode;
use App\Enums\CustomResponseMsg;
use App\Models\CustomResponse;
use App\Models\ProductUserAge;
use App\Repositories\Interfaces\IAgeRepository;
use App\ViewModels\AgeViewModel;
use Illuminate\Support\Facades\DB;

class AgeRepository extends BaseRepository implements IAgeRepository
{

    public function getIndexData(): CustomResponse
    {
        $res = new CustomResponse();
        $res->setCode(CustomResponseCode::SUCCESS->value);
        $res->setMsg(CustomResponseMsg::INIT_SUCCESS->value);
        $res->setAges($this->read());
        return $res;
    }

    public function create(AgeViewModel $ageViewModel): CustomResponse
    {
        $date = $this->getCurrentDate();
        $res = new CustomResponse();
        DB::beginTransaction();
        try{

            $model = new ProductUserAge();
            $model->minAge = $ageViewModel->minAge;
            $model->maxAge = $ageViewModel->maxAge;
            $model->fixedAge = $ageViewModel->fixedAge;
            $model->ip = $ageViewModel->ip;
            $model->modifiedBy = $ageViewModel->modifiedBy;
            $model->createdAt = $date;
            $model->updatedAt = $date;
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

    public function update(AgeViewModel $ageViewModel): CustomResponse
    {
        $date = $this->getCurrentDate();
        $res = new CustomResponse();
        DB::beginTransaction();
        try{

            ProductUserAge::where('id',$ageViewModel->id)
                ->update([
                    'minAge' => $ageViewModel->minAge,
                    'maxAge' => $ageViewModel->maxAge,
                    'fixedAge' => $ageViewModel->fixedAge,
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

    public function delete(AgeViewModel $ageViewModel): CustomResponse
    {
        $res = new CustomResponse();
        DB::beginTransaction();
        try{

            ProductUserAge::where('id',$ageViewModel->id)->delete();
            DB::commit();

            $res->setCode(CustomResponseCode::SUCCESS->value);
            $res->setMsg(CustomResponseMsg::SUCCESS->value);

        }catch (\Exception $e){
            $res->setCode(CustomResponseCode::ERROR->value);
            $res->setMsg($e->getMessage());
        }

        return $res;
    }

    public function read(): array
    {
        return ProductUserAge::select("id","minAge","maxAge","fixedAge")->get()->toArray();
    }

    public function isAgeExist(int $minAge, int $maxAge, int $fixedAge) : CustomResponse
    {
        $res = new CustomResponse();
        $isExist = ProductUserAge::where('minAge',$minAge)
            ->where('maxAge',$maxAge)
            ->where('fixedAge',$fixedAge)
            ->exists();

        if($isExist){
            $res->setCode(CustomResponseCode::ERROR->value);
            $res->setMsg(CustomResponseMsg::AGE_EXIST->value);
        }else{
            $res->setCode(CustomResponseCode::SUCCESS->value);
            $res->setMsg(CustomResponseMsg::SUCCESS->value);
        }

        return $res;
    }

}
