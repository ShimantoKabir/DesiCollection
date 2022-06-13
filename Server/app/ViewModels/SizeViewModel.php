<?php

namespace App\ViewModels;

use App\Enums\CustomResponseCode;
use App\Enums\CustomResponseMsg;
use App\Enums\OperationType;
use App\Models\CustomResponse;
use Illuminate\Http\Request;
use App\UseCases\SizeUseCase;

class SizeViewModel extends BaseViewModel
{
    public string $sizeName;
    public array $sizes;
    public SizeUseCase $sizeUseCase;

    public function __construct(SizeUseCase $sizeUseCase)
    {
        $this->sizeUseCase = $sizeUseCase;
    }

    /**
     * @param string $sizeName
     */
    public function setSizeName(string $sizeName): void
    {
        $this->sizeName = $sizeName;
    }

    /**
     * @return string
     */
    public function getSizeName(): string
    {
        return $this->sizeName;
    }

    public function getIndexData(Request $request) : CustomResponse
    {
        return $this->sizeUseCase->getIndexData();
    }

    public function save(Request $request) : CustomResponse
    {
        $inputValidationResponse = $this->checkInputValidation($request->sizeViewModel,[
            'sizeName' => 'required|string'
        ]);

        if($inputValidationResponse != CustomResponseMsg::OK->value){
            return (new CustomResponse())->setResponse(CustomResponseCode::ERROR->value, $inputValidationResponse);
        }

        $this->setSizeName($request->sizeViewModel["sizeName"]);
        $this->setIp($request->ip());
        $this->setModifiedBy($request->modifiedBy);

        return $this->sizeUseCase->save($this);

    }

    public function update(Request $request) : CustomResponse
    {
        $inputValidationResponse = $this->checkInputValidation($request->sizeViewModel,[
            'sizeName' => 'required|string'
        ]);

        if($inputValidationResponse != CustomResponseMsg::OK->value){
            return (new CustomResponse())->setResponse(CustomResponseCode::ERROR->value, $inputValidationResponse);
        }

        $this->setId($request->sizeViewModel["id"]);
        $this->setsizeName($request->sizeViewModel["sizeName"]);
        $this->setIp($request->ip());
        $this->setModifiedBy($request->modifiedBy);

        return $this->sizeUseCase->update($this);
    }

    public function remove(Request $request) : CustomResponse
    {
        $inputValidationResponse = $this->checkInputValidation($request->sizeViewModel,[
            'id' => 'required|int'
        ]);

        if($inputValidationResponse != CustomResponseMsg::OK->value){
            return (new CustomResponse())->setResponse(CustomResponseCode::ERROR->value, $inputValidationResponse);
        }

        $this->setId($request->sizeViewModel["id"]);
        return $this->sizeUseCase->remove($this);
    }
}
