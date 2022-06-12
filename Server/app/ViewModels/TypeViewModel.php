<?php

namespace App\ViewModels;

use App\Enums\CustomResponseCode;
use App\Enums\CustomResponseMsg;
use App\Enums\OperationType;
use App\Models\CustomResponse;
use App\UseCases\TypeUseCase;
use Illuminate\Http\Request;

class TypeViewModel extends BaseViewModel
{
    public string $typeName;
    public array $types;
    public object $model;
    public TypeUseCase $typeUseCase;

    public function __construct(TypeUseCase $typeUseCase)
    {
        $this->typeUseCase = $typeUseCase;
    }

    public function getId() : int
    {
        return $this->id;
    }

    public function setTypeName(string $typeName){
        $this->typeName = $typeName;
    }

    public function getTypeName() : string
    {
        return $this->typeName;
    }

    public function getIndexData(Request $request) : CustomResponse
    {
        $authResponse = $this->checkAuthValidation($request,OperationType::READ);

        if($authResponse != CustomResponseMsg::OK->value){
            return (new CustomResponse())->setResponse(CustomResponseCode::ERROR->value, $authResponse);
        }

        return $this->typeUseCase->getIndexData();
    }

    public function save(Request $request) : CustomResponse
    {
        $authResponse = $this->checkAuthValidation($request,OperationType::CREATE);

        if($authResponse != CustomResponseMsg::OK->value){
            return (new CustomResponse())->setResponse(CustomResponseCode::ERROR->value, $authResponse);
        }

        $inputValidationResponse = $this->checkInputValidation($request->typeViewModel,[
            'typeName' => 'required|string'
        ]);

        if($inputValidationResponse != CustomResponseMsg::OK->value){
            return (new CustomResponse())->setResponse(CustomResponseCode::ERROR->value, $inputValidationResponse);
        }

        $this->setTypeName($request->typeViewModel["typeName"]);
        $this->setIp($request->ip());
        $this->setModifiedBy(0);

        return $this->typeUseCase->save($this);

    }

    public function update(Request $request) : CustomResponse
    {
        $authResponse = $this->checkAuthValidation($request,OperationType::CREATE);

        if($authResponse != CustomResponseMsg::OK->value){
            return (new CustomResponse())->setResponse(CustomResponseCode::ERROR->value, $authResponse);
        }

        $inputValidationResponse = $this->checkInputValidation($request->typeViewModel,[
            'typeName' => 'required|string'
        ]);

        if($inputValidationResponse != CustomResponseMsg::OK->value){
            return (new CustomResponse())->setResponse(CustomResponseCode::ERROR->value, $inputValidationResponse);
        }

        $this->setId($request->typeViewModel["id"]);
        $this->setTypeName($request->typeViewModel["typeName"]);
        $this->setIp($request->ip());
        $this->setModifiedBy(0);

        return $this->typeUseCase->update($this);
    }

    public function remove(Request $request) : CustomResponse
    {

        $authResponse = $this->checkAuthValidation($request,OperationType::CREATE);

        if($authResponse != CustomResponseMsg::OK->value){
            return (new CustomResponse())->setResponse(CustomResponseCode::ERROR->value, $authResponse);
        }

        $inputValidationResponse = $this->checkInputValidation($request->typeViewModel,[
            'id' => 'required|int'
        ]);

        if($inputValidationResponse != CustomResponseMsg::OK->value){
            return (new CustomResponse())->setResponse(CustomResponseCode::ERROR->value, $inputValidationResponse);
        }

        $this->setId($request->typeViewModel["id"]);
        return $this->typeUseCase->remove($this);
    }

}
