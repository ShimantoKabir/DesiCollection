<?php

namespace App\Repositories;

use App\Enums\CustomResponseCode;
use App\Enums\CustomResponseMsg;
use App\Models\CustomRequest;
use App\Models\CustomResponse;
use App\Models\Fabric;
use App\Repositories\Interfaces\IFabricRepository;
use Illuminate\Support\Facades\DB;

class FabricRepository extends BaseRepository implements IFabricRepository
{

    public function getIndexData() : CustomResponse
    {
        $this->customResponse->code = CustomResponseCode::SUCCESS;
        $this->customResponse->msg = CustomResponseMsg::SUCCESS;
        $this->customResponse->fabrics = Fabric::all()->all();

        return $this->customResponse;
    }

    public function create(CustomRequest $request) : CustomResponse
    {

        DB::beginTransaction();
        try{

            $model = new Fabric();
            $model->fabric_name = $request->fabricViewModel->fabricName;
            $model->ip = $request->fabricViewModel->ip;
            $model->modified_by = $request->fabricViewModel->modifiedBy;
            $model->created_at = date('Y-m-d H:i:s');
            $model->save();

            $this->customResponse->code = CustomResponseCode::SUCCESS->value;
            $this->customResponse->msg = CustomResponseMsg::SUCCESS->value;

        }catch (\Exception $e){
            $this->customResponse->code = CustomResponseCode::ERROR->value;
            $this->customResponse->msg = $e->getMessage();
        }

        return $this->customResponse;
    }

    public function read(CustomRequest $request) : CustomResponse
    {
        // TODO: Implement read() method.
        return $this->customResponse;
    }

    public function update(CustomRequest $request) : CustomResponse
    {
        // TODO: Implement update() method.
        return $this->customResponse;
    }

    public function delete(CustomRequest $request) : CustomResponse
    {
        // TODO: Implement delete() method.
        return $this->customResponse;
    }
}
