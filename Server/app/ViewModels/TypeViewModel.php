<?php

namespace App\ViewModels;

use App\Enums\CustomResponseCode;
use App\Enums\CustomResponseMsg;
use App\Models\CustomResponse;
use App\UseCases\TypeUseCase;
use Illuminate\Http\Request;

class TypeViewModel extends BaseViewModel
{
    public string $typeName;
    public TypeUseCase $typeUseCase;

    public function __construct(TypeUseCase $typeUseCase)
    {
        $this->typeUseCase = $typeUseCase;
    }

    /**
     * @param string $typeName
     */
    public function setTypeName(string $typeName): void
    {
        $this->typeName = $typeName;
    }

    /**
     * @return string
     */
    public function getTypeName(): string
    {
        return $this->typeName;
    }

    public function getIndexData(Request $request) : CustomResponse
    {
        return $this->typeUseCase->getIndexData();
    }

    public function save(Request $request) : CustomResponse
    {
        $inputValidationResponse = $this->checkInputValidation($request->typeViewModel,[
            'typeName' => 'required|string'
        ]);

        if($inputValidationResponse != CustomResponseMsg::OK->value){
            return (new CustomResponse())->setResponse(CustomResponseCode::ERROR->value, $inputValidationResponse);
        }

        $this->setTypeName($request->typeViewModel["typeName"]);
        $this->setIp($request->ip());
        $this->setModifiedBy($request->modifiedBy);

        return $this->typeUseCase->save($this);
    }

    public function update(Request $request) : CustomResponse
    {
        $inputValidationResponse = $this->checkInputValidation($request->typeViewModel,[
            'typeName' => 'required|string'
        ]);

        if($inputValidationResponse != CustomResponseMsg::OK->value){
            return (new CustomResponse())->setResponse(CustomResponseCode::ERROR->value, $inputValidationResponse);
        }

        $this->setId($request->typeViewModel["id"]);
        $this->setTypeName($request->typeViewModel["typeName"]);
        $this->setIp($request->ip());
        $this->setModifiedBy($request->modifiedBy);

        return $this->typeUseCase->update($this);
    }

    public function remove(Request $request) : CustomResponse
    {
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
