<?php

namespace App\ViewModels;

use App\Enums\CustomResponseCode;
use App\Enums\OperationType;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class FabricViewModel extends BaseViewModel
{
    public int $id;
    public string $fabricName;
    public string $ip;
    public int $modifiedBy;
    public array $fabrics;

    public function getIndexData(Request $request) : FabricViewModel
    {
        $authResponse = $this->checkAuthValidation($request,OperationType::READ);

        if($authResponse->code == CustomResponseCode::ERROR->value){
            $this->msg = $authResponse->msg;
            $this->code = $authResponse->code;
        }else{
            $data = $this->fabricUseCase->getIndexData();
            $this->code = $data->code;
            $this->msg = $data->msg;
            $this->fabrics = $data->fabrics;
        }

        return $this;
    }

    public function save(Request $request) : FabricViewModel
    {
        $authResponse = $this->checkAuthValidation($request,OperationType::CREATE);

        $validator = Validator::make($request->fabricViewModel,[
            'fabricName' => 'required|string',
        ]);

        if($authResponse->code == CustomResponseCode::ERROR->value){
            $this->msg = $authResponse->msg;
            $this->code = $authResponse->code;
        }else{

            if($validator->fails()){
                $this->code = CustomResponseCode::ERROR->value;
                $this->msg = $validator->errors()->first();
            }else{
                $this->customRequest->fabricViewModel->fabricName = $request->fabricViewModel["fabricName"];
                $this->customRequest->fabricViewModel->ip = $request->ip();
                $this->customRequest->fabricViewModel->modifiedBy = 1;

                $data = $this->fabricUseCase->save($this->customRequest);

                $this->code = $data->code;
                $this->msg = $data->msg;
                $this->fabrics = $data->fabrics;
            }
        }

        return $this;

    }


}
