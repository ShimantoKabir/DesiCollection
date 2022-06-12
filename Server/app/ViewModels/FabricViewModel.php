<?php

namespace App\ViewModels;

use App\Enums\CustomResponseCode;
use App\Enums\CustomResponseMsg;
use App\Enums\OperationType;
use App\Models\CustomResponse;
use App\UseCases\FabricUseCase;
use Illuminate\Http\Request;

class FabricViewModel extends BaseViewModel
{
    public string $fabricName;
    public array $fabrics;
    public object $model;
    public FabricUseCase $fabricUseCase;

    public function __construct(FabricUseCase $fabricUseCase)
    {
        $this->fabricUseCase = $fabricUseCase;
    }

    public function setFabricName(string $fabricName){
        $this->fabricName = $fabricName;
    }

    public function getIndexData(Request $request) : CustomResponse
    {
        $authResponse = $this->checkAuthValidation($request,OperationType::READ);

        if($authResponse != CustomResponseMsg::OK->value){
            return (new CustomResponse())->setResponse(CustomResponseCode::ERROR->value, $authResponse);
        }

        return $this->fabricUseCase->getIndexData();
    }

    public function save(Request $request) : CustomResponse
    {
        $authResponse = $this->checkAuthValidation($request,OperationType::CREATE);

        if($authResponse != CustomResponseMsg::OK->value){
            return (new CustomResponse())->setResponse(CustomResponseCode::ERROR->value, $authResponse);
        }

        $inputValidationResponse = $this->checkInputValidation($request->fabricViewModel,[
            'fabricName' => 'required|string'
        ]);

        if($inputValidationResponse != CustomResponseMsg::OK->value){
            return (new CustomResponse())->setResponse(CustomResponseCode::ERROR->value, $inputValidationResponse);
        }

        $this->setFabricName($request->fabricViewModel["fabricName"]);
        $this->setIp($request->ip());
        $this->setModifiedBy(0);

        return $this->fabricUseCase->save($this);

    }

    public function update(Request $request) : CustomResponse
    {
        $authResponse = $this->checkAuthValidation($request,OperationType::CREATE);

        if($authResponse != CustomResponseMsg::OK->value){
            return (new CustomResponse())->setResponse(CustomResponseCode::ERROR->value, $authResponse);
        }

        $inputValidationResponse = $this->checkInputValidation($request->fabricViewModel,[
            'fabricName' => 'required|string'
        ]);

        if($inputValidationResponse != CustomResponseMsg::OK->value){
            return (new CustomResponse())->setResponse(CustomResponseCode::ERROR->value, $inputValidationResponse);
        }

        $this->setId($request->fabricViewModel["id"]);
        $this->setFabricName($request->fabricViewModel["fabricName"]);
        $this->setIp($request->ip());
        $this->setModifiedBy(0);

        return $this->fabricUseCase->update($this);
    }

    public function remove(Request $request) : CustomResponse
    {

        $authResponse = $this->checkAuthValidation($request,OperationType::CREATE);

        if($authResponse != CustomResponseMsg::OK->value){
            return (new CustomResponse())->setResponse(CustomResponseCode::ERROR->value, $authResponse);
        }

        $inputValidationResponse = $this->checkInputValidation($request->fabricViewModel,[
            'id' => 'required|int'
        ]);

        if($inputValidationResponse != CustomResponseMsg::OK->value){
            return (new CustomResponse())->setResponse(CustomResponseCode::ERROR->value, $inputValidationResponse);
        }

        $this->setId($request->fabricViewModel["id"]);
        return $this->fabricUseCase->remove($this);
    }

}
