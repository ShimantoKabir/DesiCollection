<?php

namespace App\Repositories;

use App\Enums\CustomResponseCode;
use App\Enums\CustomResponseMsg;
use App\Models\CustomResponse;
use App\Models\Size;
use App\Repositories\Interfaces\ISizeRepository;
use App\ViewModels\SizeViewModel;
use Illuminate\Support\Facades\DB;

class SizeRepository extends BaseRepository implements ISizeRepository
{

    public function getIndexData() : CustomResponse
    {
        $res = new CustomResponse();
        $res->setCode(CustomResponseCode::SUCCESS->value);
        $res->setMsg(CustomResponseMsg::INIT_SUCCESS->value);
        $res->setSizes($this->read());
        return $res;
    }

    public function create(SizeViewModel $sizeViewModel) : CustomResponse
    {

        $date = $this->getCurrentDate();
        $res = new CustomResponse();
        DB::beginTransaction();
        try{

            $model = new Size();
            $model->sizeName = $sizeViewModel->getSizeName();
            $model->ip = $sizeViewModel->getIp();
            $model->modifiedBy = $sizeViewModel->getModifiedBy();
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

    public function read() : array
    {
        return Size::select("id","sizeName")->get()->toArray();
    }

    public function update(SizeViewModel $sizeViewModel) : CustomResponse
    {
        $date = $this->getCurrentDate();
        $res = new CustomResponse();
        DB::beginTransaction();
        try{

            Size::where('id',$sizeViewModel->id)
                ->update([
                    'sizeName' => $sizeViewModel->getSizeName(),
                    'updatedAt' => $date,
                    'ip' => $sizeViewModel->getIp(),
                    'modifiedBy' => $sizeViewModel->getModifiedBy()
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

    public function isSizeNameExist($sizeName) : CustomResponse
    {

        $res = new CustomResponse();
        $isExist = Size::where('sizeName',$sizeName)->exists();

        if($isExist){
            $res->setCode(CustomResponseCode::ERROR->value);
            $res->setMsg(CustomResponseMsg::SIZE_NAME_EXIST->value);
        }else{
            $res->setCode(CustomResponseCode::SUCCESS->value);
            $res->setMsg(CustomResponseMsg::SUCCESS->value);
        }

        return $res;

    }

    public function delete(SizeViewModel $sizeViewModel) : CustomResponse
    {
        $res = new CustomResponse();
        DB::beginTransaction();
        try{

            Size::where('id',$sizeViewModel->getId())->delete();
            DB::commit();

            $res->setCode(CustomResponseCode::SUCCESS->value);
            $res->setMsg(CustomResponseMsg::SUCCESS->value);

        }catch (\Exception $e){
            $res->setCode(CustomResponseCode::ERROR->value);
            $res->setMsg($e->getMessage());
        }

        return $res;
    }
}
