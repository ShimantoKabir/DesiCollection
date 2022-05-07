<?php

namespace App\Repositories;

use App\Enums\CustomResponseCode;
use App\Enums\CustomResponseMsg;
use App\Models\CustomResponse;
use App\Models\Fabric;
use App\Repositories\Interfaces\IFabricRepository;
use App\ViewModels\FabricViewModel;
use Illuminate\Support\Facades\DB;

class FabricRepository extends BaseRepository implements IFabricRepository
{

    public function getIndexData() : CustomResponse
    {
        $res = new CustomResponse();
        $res->setCode(CustomResponseCode::SUCCESS->value);
        $res->setMsg(CustomResponseMsg::INIT_SUCCESS->value);
        $res->setFabrics(Fabric::select("id","fabric_name AS fabricName")->get()->toArray());
        return $res;
    }

    public function create(FabricViewModel $fabricViewModel) : CustomResponse
    {
        $res = new CustomResponse();
        DB::beginTransaction();
        try{

            $model = new Fabric();
            $model->fabric_name = $fabricViewModel->fabricName;
            $model->ip = $fabricViewModel->ip;
            $model->modified_by = $fabricViewModel->modifiedBy;
            $model->created_at = date('Y-m-d H:i:s');
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

    public function read(FabricViewModel $fabricViewModel) : CustomResponse
    {
        $res = new CustomResponse();
        return $res;
    }

    public function update(FabricViewModel $fabricViewModel) : CustomResponse
    {
        $res = new CustomResponse();
        DB::beginTransaction();
        try{

            Fabric::where('id',$fabricViewModel->id)
            ->update([
                'fabric_name'=>$fabricViewModel->fabricName
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

    public function isFabricNameExist($fabricName) : CustomResponse
    {

        $res = new CustomResponse();
        $isExist = Fabric::where('fabric_name',$fabricName)->exists();

        if($isExist){
            $res->setCode(CustomResponseCode::ERROR->value);
            $res->setMsg(CustomResponseMsg::FABRIC_NAME_EXIST->value);
        }else{
            $res->setCode(CustomResponseCode::SUCCESS->value);
            $res->setMsg(CustomResponseMsg::SUCCESS->value);
        }

        return $res;

    }

    public function delete(FabricViewModel $fabricViewModel) : CustomResponse
    {
        $res = new CustomResponse();
        DB::beginTransaction();
        try{

            Fabric::where('id',$fabricViewModel->id)->delete();
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
