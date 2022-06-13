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
    public ?int $minAge;
    public ?int $maxAge;
    public ?int $fixedAge;
    public array $ages;
    public object $model;
    public bool $isFixedAgeEnable;
    public AgeUseCase $ageUseCase;

    public function __construct(AgeUseCase $ageUseCase)
    {
        $this->ageUseCase = $ageUseCase;
    }

    public function setMinAge(?int $minAge){
        $this->minAge = $minAge;
    }

    public function setMaxAge(?int $maxAge){
        $this->maxAge = $maxAge;
    }

    public function setFixedAge(?int $fixedAge){
        $this->fixedAge = $fixedAge;
    }

    public function setFixedAgeEnableStatus(?int $isFixedAgeEnable){
        $this->isFixedAgeEnable = $isFixedAgeEnable;
    }

    public function getFixedAgeEnableStatus() : bool
    {
        return $this->isFixedAgeEnable;
    }

    public function getIndexData(Request $request) : CustomResponse
    {
        return $this->ageUseCase->getIndexData();
    }

    public function save(Request $request) : CustomResponse
    {
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
        $this->setFixedAgeEnableStatus($request->ageViewModel["isFixedAgeEnable"]);

        $this->setIp($request->ip());
        $this->setModifiedBy($request->modifiedBy);

        return $this->ageUseCase->save($this);

    }

    public function update(Request $request) : CustomResponse
    {
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
        $this->setFixedAgeEnableStatus($request->ageViewModel["isFixedAgeEnable"]);
        $this->setIp($request->ip());
        $this->setModifiedBy($request->modifiedBy);

        return $this->ageUseCase->update($this);
    }

    public function remove(Request $request) : CustomResponse
    {
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
