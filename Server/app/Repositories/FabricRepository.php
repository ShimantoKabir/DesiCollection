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
        $this->customResponse->setCode(CustomResponseCode::SUCCESS->value);
        $this->customResponse->setMsg(CustomResponseMsg::INIT_SUCCESS->value);
        $this->customResponse->setFabrics(Fabric::select("id","fabric_name AS fabricName")->get()->toArray());

        return $this->customResponse;
    }

    public function create(FabricViewModel $fabricViewModel) : CustomResponse
    {
        DB::beginTransaction();
        try{

            $model = new Fabric();
            $model->fabric_name = $fabricViewModel->fabricName;
            $model->ip = $fabricViewModel->ip;
            $model->modified_by = $fabricViewModel->modifiedBy;
            $model->created_at = date('Y-m-d H:i:s');
            $model->save();

            $this->customResponse->setModel($model);
            $this->customResponse->setCode(CustomResponseCode::SUCCESS->value);
            $this->customResponse->setMsg(CustomResponseMsg::SUCCESS->value);

            DB::commit();

        }catch (\Exception $e){
            $this->customResponse->setCode(CustomResponseCode::ERROR->value);
            $this->customResponse->setMsg($e->getMessage());
        }

        return $this->customResponse;
    }

    public function read(FabricViewModel $fabricViewModel) : CustomResponse
    {
        // TODO: Implement read() method.
        return $this->customResponse;
    }

    public function update(FabricViewModel $fabricViewModel) : CustomResponse
    {
        DB::beginTransaction();
        try{

            Fabric::where('id',$fabricViewModel->id)
            ->update([
                'fabric_name'=>$fabricViewModel->fabricName
            ]);

            DB::commit();

        }catch (\Exception $e){
            $this->customResponse->setCode(CustomResponseCode::ERROR->value);
            $this->customResponse->setMsg($e->getMessage());
        }

        return $this->customResponse;
    }

    public function isFabricNameExist($fabricName) : CustomResponse
    {

        $isExist = Fabric::where('fabric_name',$fabricName)->exists();

        if($isExist){
            $this->customResponse->setCode(CustomResponseCode::ERROR->value);
            $this->customResponse->setMsg(CustomResponseMsg::FABRIC_NAME_EXIST->value);
        }else{
            $this->customResponse->setCode(CustomResponseCode::SUCCESS->value);
            $this->customResponse->setMsg(CustomResponseMsg::SUCCESS->value);
        }

        return $this->customResponse;

    }

    public function delete(FabricViewModel $fabricViewModel) : CustomResponse
    {
        DB::beginTransaction();
        try{

            Fabric::where('id',$fabricViewModel->id)->delete();

            DB::commit();

        }catch (\Exception $e){
            $this->customResponse->setCode(CustomResponseCode::ERROR->value);
            $this->customResponse->setMsg($e->getMessage());
        }

        return $this->customResponse;
    }
}
