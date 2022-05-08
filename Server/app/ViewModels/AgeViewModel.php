<?php

namespace App\ViewModels;

use App\Enums\CustomResponseCode;
use App\Enums\CustomResponseMsg;
use App\Enums\OperationType;
use App\Models\CustomResponse;
use App\UseCases\AgeUseCase;
use Illuminate\Http\Request;

class AgeViewModel extends BaseViewModel
{
    public int $id;
    public int $minAge;
    public int $maxAge;
    public int $fixedAge;
    public string $ip;
    public int $modifiedBy;
    public array $ages;
    public object $model;
    public AgeUseCase $ageUseCase;

    public function __construct(AgeUseCase $ageUseCase)
    {
        $this->ageUseCase = $ageUseCase;
    }

    public function setId(int $id){
        $this->id = $id;
    }

    public function setMinAge(int $minAge){
        $this->minAge = $minAge;
    }

    public function setMaxAge(int $maxAge){
        $this->maxAge = $maxAge;
    }

    public function setFixedAge(int $fixedAge){
        $this->fixedAge = $fixedAge;
    }

    public function setIp(string $ip){
        $this->ip = $ip;
    }

    public function setModifiedBy(int $modifiedBy){
        $this->modifiedBy = $modifiedBy;
    }

    public function getIndexData(Request $request) : CustomResponse
    {
        $authResponse = $this->checkAuthValidation($request,OperationType::READ);

        if($authResponse != CustomResponseMsg::OK->value){
            return (new CustomResponse())->setResponse(CustomResponseCode::ERROR->value, $authResponse);
        }

        return $this->ageUseCase->getIndexData();
    }

    public function save(Request $request) : CustomResponse
    {
        $authResponse = $this->checkAuthValidation($request,OperationType::CREATE);

        if($authResponse != CustomResponseMsg::OK->value){
            return (new CustomResponse())->setResponse(CustomResponseCode::ERROR->value, $authResponse);
        }

        $inputValidationResponse = $this->checkInputValidation($request->ageViewModel,[
            'minAge' => 'int',
            'maxAge' => 'int',
            'fixedAge' => 'int'
        ]);

        if($inputValidationResponse != CustomResponseMsg::OK->value){
            return (new CustomResponse())->setResponse(CustomResponseCode::ERROR->value, $inputValidationResponse);
        }

        $this->setMinAge($request->ageViewModel["minAge"]);
        $this->setMaxAge($request->ageViewModel["maxAge"]);
        $this->setFixedAge($request->ageViewModel["fixedAge"]);
        $this->setIp($request->ip());
        $this->setModifiedBy(0);

        return $this->ageUseCase->save($this);

    }

    public function update(Request $request) : CustomResponse
    {
        $authResponse = $this->checkAuthValidation($request,OperationType::CREATE);

        if($authResponse != CustomResponseMsg::OK->value){
            return (new CustomResponse())->setResponse(CustomResponseCode::ERROR->value, $authResponse);
        }

        $inputValidationResponse = $this->checkInputValidation($request->ageViewModel,[
            'minAge' => 'int',
            'maxAge' => 'int',
            'fixedAge' => 'int'
        ]);

        if($inputValidationResponse != CustomResponseMsg::OK->value){
            return (new CustomResponse())->setResponse(CustomResponseCode::ERROR->value, $inputValidationResponse);
        }

        $this->setId($request->ageViewModel["id"]);
        $this->setMinAge($request->ageViewModel["minAge"]);
        $this->setMaxAge($request->ageViewModel["maxAge"]);
        $this->setFixedAge($request->ageViewModel["fixedAge"]);
        $this->setIp($request->ip());
        $this->setModifiedBy(0);

        return $this->ageUseCase->update($this);
    }

    public function remove(Request $request) : CustomResponse
    {

        $authResponse = $this->checkAuthValidation($request,OperationType::CREATE);

        if($authResponse != CustomResponseMsg::OK->value){
            return (new CustomResponse())->setResponse(CustomResponseCode::ERROR->value, $authResponse);
        }

        $inputValidationResponse = $this->checkInputValidation($request->ageViewModel,[
            'id' => 'required|int'
        ]);

        if($inputValidationResponse != CustomResponseMsg::OK->value){
            return (new CustomResponse())->setResponse(CustomResponseCode::ERROR->value, $inputValidationResponse);
        }

        $this->setId($request->ageViewModel["id"]);
        return $this->ageUseCase->remove($this);
    }
}
