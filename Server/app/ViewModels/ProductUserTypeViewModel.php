<?php

namespace App\ViewModels;

use App\Enums\CustomResponseCode;
use App\Enums\CustomResponseMsg;
use App\Enums\OperationType;
use App\Models\CustomResponse;
use App\UseCases\ProductUserTypeUseCase;
use Illuminate\Http\Request;

class ProductUserTypeViewModel extends BaseViewModel
{

    public string $userTypeName;
    public array $userTypes;
    public object $model;
    public ProductUserTypeUseCase $productUserTypeUseCase;

    public function getId() : int
    {
        return $this->id;
    }

    public function setUserTypeName(string $userTypeName)
    {
        $this->userTypeName = $userTypeName;
    }

    public function getUserTypeName() : string
    {
        return $this->userTypeName;
    }

    public function getIp() : string
    {
        return $this->ip;
    }

    public function getModifiedBy() : int
    {
        return $this->modifiedBy;
    }

    public function setUserTypes(array $userTypes)
    {
        $this->userTypes = $userTypes;
    }

    public function getUserTypes() : array
    {
        return $this->userTypes;
    }

    public function setModel(object $model)
    {
        $this->model = $model;
    }

    public function getModel() : object
    {
        return $this->model;
    }

    public function __construct(ProductUserTypeUseCase $productUserTypeUseCase)
    {
        $this->productUserTypeUseCase = $productUserTypeUseCase;
    }

    public function getIndexData(Request $request) : CustomResponse
    {
        $authResponse = $this->checkAuthValidation($request,OperationType::READ);

        if($authResponse != CustomResponseMsg::OK->value){
            return (new CustomResponse())->setResponse(CustomResponseCode::ERROR->value, $authResponse);
        }

        return $this->productUserTypeUseCase->getIndexData();
    }

    public function save(Request $request) : CustomResponse
    {
        $authResponse = $this->checkAuthValidation($request,OperationType::CREATE);

        if($authResponse != CustomResponseMsg::OK->value){
            return (new CustomResponse())->setResponse(CustomResponseCode::ERROR->value, $authResponse);
        }

        $inputValidationResponse = $this->checkInputValidation($request->userTypeViewModel,[
            'userTypeName' => 'required|string'
        ]);

        if($inputValidationResponse != CustomResponseMsg::OK->value){
            return (new CustomResponse())->setResponse(CustomResponseCode::ERROR->value, $inputValidationResponse);
        }

        $this->setUserTypeName($request->userTypeViewModel["userTypeName"]);
        $this->setIp($request->ip());
        $this->setModifiedBy(0);

        return $this->productUserTypeUseCase->save($this);
    }

    public function update(Request $request) : CustomResponse
    {
        $authResponse = $this->checkAuthValidation($request,OperationType::CREATE);

        if($authResponse != CustomResponseMsg::OK->value){
            return (new CustomResponse())->setResponse(CustomResponseCode::ERROR->value, $authResponse);
        }

        $inputValidationResponse = $this->checkInputValidation($request->userTypeViewModel,[
            'userTypeName' => 'required|string'
        ]);

        if($inputValidationResponse != CustomResponseMsg::OK->value){
            return (new CustomResponse())->setResponse(CustomResponseCode::ERROR->value, $inputValidationResponse);
        }

        $this->setId($request->userTypeViewModel["id"]);
        $this->setUserTypeName($request->userTypeViewModel["userTypeName"]);
        $this->setIp($request->ip());
        $this->setModifiedBy(0);

        return $this->productUserTypeUseCase->update($this);
    }

    public function remove(Request $request) : CustomResponse
    {

        $authResponse = $this->checkAuthValidation($request,OperationType::CREATE);

        if($authResponse != CustomResponseMsg::OK->value){
            return (new CustomResponse())->setResponse(CustomResponseCode::ERROR->value, $authResponse);
        }

        $inputValidationResponse = $this->checkInputValidation($request->userTypeViewModel,[
            'id' => 'required|int'
        ]);

        if($inputValidationResponse != CustomResponseMsg::OK->value){
            return (new CustomResponse())->setResponse(CustomResponseCode::ERROR->value, $inputValidationResponse);
        }

        $this->setId($request->userTypeViewModel["id"]);
        return $this->productUserTypeUseCase->remove($this);
    }

}
