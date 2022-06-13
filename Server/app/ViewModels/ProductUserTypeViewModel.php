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
    public ProductUserTypeUseCase $productUserTypeUseCase;

    public function __construct(ProductUserTypeUseCase $productUserTypeUseCase)
    {
        $this->productUserTypeUseCase = $productUserTypeUseCase;
    }

    /**
     * @param string $userTypeName
     */
    public function setUserTypeName(string $userTypeName): void
    {
        $this->userTypeName = $userTypeName;
    }

    /**
     * @return string
     */
    public function getUserTypeName(): string
    {
        return $this->userTypeName;
    }

    public function getIndexData(Request $request) : CustomResponse
    {
        return $this->productUserTypeUseCase->getIndexData();
    }

    public function save(Request $request) : CustomResponse
    {
        $inputValidationResponse = $this->checkInputValidation($request->userTypeViewModel,[
            'userTypeName' => 'required|string'
        ]);

        if($inputValidationResponse != CustomResponseMsg::OK->value){
            return (new CustomResponse())->setResponse(CustomResponseCode::ERROR->value, $inputValidationResponse);
        }

        $this->setUserTypeName($request->userTypeViewModel["userTypeName"]);
        $this->setIp($request->ip());
        $this->setModifiedBy($request->modifiedBy);

        return $this->productUserTypeUseCase->save($this);
    }

    public function update(Request $request) : CustomResponse
    {
        $inputValidationResponse = $this->checkInputValidation($request->userTypeViewModel,[
            'userTypeName' => 'required|string'
        ]);

        if($inputValidationResponse != CustomResponseMsg::OK->value){
            return (new CustomResponse())->setResponse(CustomResponseCode::ERROR->value, $inputValidationResponse);
        }

        $this->setId($request->userTypeViewModel["id"]);
        $this->setUserTypeName($request->userTypeViewModel["userTypeName"]);
        $this->setIp($request->ip());
        $this->setModifiedBy($request->modifiedBy);

        return $this->productUserTypeUseCase->update($this);
    }

    public function remove(Request $request) : CustomResponse
    {
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
