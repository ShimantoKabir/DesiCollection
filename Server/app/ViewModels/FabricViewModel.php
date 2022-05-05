<?php

namespace App\ViewModels;

use App\Enums\CustomResponseCode;
use App\Enums\CustomResponseMsg;
use App\Enums\OperationType;
use App\Models\CustomResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class FabricViewModel extends BaseViewModel
{
    public int $id;
    public string $fabricName;
    public string $ip;
    public int $modifiedBy;
    public array $fabrics;
    public object $model;

    public function setId(int $id){
        $this->id = $id;
    }

    public function setFabricName(string $fabricName){
        $this->fabricName = $fabricName;
    }

    public function setIp(string $ip){
        $this->ip = $ip;
    }

    public function setModifiedBy(int $modifiedBy){
        $this->modifiedBy = $modifiedBy;
    }

    public function setFabrics(array $fabrics){
        $this->fabrics = $fabrics;
    }

    public function setModel(object $model){
        $this->model = $model;
    }

    public function getModel() : object
    {
        return $this->model;
    }

    public function getIndexData(Request $request) : FabricViewModel
    {
        $authResponse = $this->checkAuthValidation($request,OperationType::READ);

        if($authResponse->code == CustomResponseCode::ERROR->value){
            $this->setMsg($authResponse->msg);
            $this->setCode($authResponse->code);
        }else{
            $data = $this->fabricUseCase->getIndexData();
            $this->setCode($data->code);
            $this->setMsg($data->msg);
            $this->setFabrics($data->fabrics);
        }

        return $this;
    }

    public function save(Request $request) : FabricViewModel
    {
        $authResponse = $this->checkAuthValidation($request,OperationType::CREATE);

        if($authResponse->code == CustomResponseCode::ERROR->value){
            $this->msg = $authResponse->msg;
            $this->code = $authResponse->code;
        }else{

            $inputValidationResponse = $this->checkInputValidation($request,[
                'fabricName' => 'required|string'
            ]);

            if($inputValidationResponse->code == CustomResponseCode::ERROR->value){

                $this->setMsg($inputValidationResponse->code);
                $this->setCode($inputValidationResponse->msg);

            }else{

                $this->setFabricName($request->fabricViewModel["fabricName"]);
                $this->setIp($request->ip());
                $this->setModifiedBy($authResponse->modifiedBy);

                $data = $this->fabricUseCase->save($this);

                $this->setModel($data->getModel());
                $this->setCode($data->code);
                $this->setMsg($data->msg);

            }
        }

        return $this;

    }

    public function update(Request $request) : FabricViewModel
    {

        $authResponse = $this->checkAuthValidation($request,OperationType::UPDATE);

        if($authResponse->code == CustomResponseCode::ERROR->value){
            $this->setMsg($authResponse->msg);
            $this->setCode($authResponse->code);
        }else{

            $inputValidationResponse = $this->checkInputValidation($request,[
                'fabricName' => 'required|string',
            ]);

            if($inputValidationResponse->code == CustomResponseCode::ERROR->value){

                $this->setMsg($inputValidationResponse->code);
                $this->setCode($inputValidationResponse->msg);

            }else{

                $this->setId($request->fabricViewModel["id"]);
                $this->setFabricName($request->fabricViewModel["fabricName"]);
                $this->setIp($request->ip());
                $this->setModifiedBy($authResponse->modifiedBy);

                $data = $this->fabricUseCase->update($this);

                $this->setCode($data->code);
                $this->setMsg($data->msg);
            }
        }

        return $this;
    }

    public function remove(Request $request) : FabricViewModel
    {

        $authResponse = $this->checkAuthValidation($request,OperationType::DELETE);

        if($authResponse->code == CustomResponseCode::ERROR->value){
            $this->setMsg($authResponse->msg);
            $this->setCode($authResponse->code);
        }else{

            $inputValidationResponse = $this->checkInputValidation($request,[
                'id' => 'required|int',
            ]);

            if($inputValidationResponse->code == CustomResponseCode::ERROR->value){

                $this->setMsg($inputValidationResponse->code);
                $this->setCode($inputValidationResponse->msg);

            }else{

                $data = $this->fabricUseCase->remove($this);
                $this->setCode($data->code);
                $this->setMsg($data->msg);
            }
        }

        return $this;
    }

    protected function checkInputValidation(Request $request, array $rules) : CustomResponse
    {

        $validator = Validator::make($request->fabricViewModel, $rules);

        if($validator->fails()){
            $this->customResponse->setCode(CustomResponseCode::ERROR->value);
            $this->customResponse->setMsg($validator->errors()->first());
        }else{
            $this->customResponse->setCode(CustomResponseCode::SUCCESS->value);
            $this->customResponse->setMsg(CustomResponseMsg::SUCCESS->value);
        }

        return $this->customResponse;
    }

}
