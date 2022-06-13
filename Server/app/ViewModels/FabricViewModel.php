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
    public FabricUseCase $fabricUseCase;

    public function __construct(FabricUseCase $fabricUseCase)
    {
        $this->fabricUseCase = $fabricUseCase;
    }

    /**
     * @return array
     */
    public function getFabrics(): array
    {
        return $this->fabrics;
    }

    /**
     * @param array $fabrics
     */
    public function setFabrics(array $fabrics): void
    {
        $this->fabrics = $fabrics;
    }

    /**
     * @param string $fabricName
     */
    public function setFabricName(string $fabricName): void
    {
        $this->fabricName = $fabricName;
    }

    /**
     * @return string
     */
    public function getFabricName(): string
    {
        return $this->fabricName;
    }

    public function getIndexData(Request $request) : CustomResponse
    {
        return $this->fabricUseCase->getIndexData();
    }

    public function save(Request $request) : CustomResponse
    {
        $inputValidationResponse = $this->checkInputValidation($request->fabricViewModel,[
            'fabricName' => 'required|string'
        ]);

        if($inputValidationResponse != CustomResponseMsg::OK->value){
            return (new CustomResponse())->setResponse(CustomResponseCode::ERROR->value, $inputValidationResponse);
        }

        $this->setFabricName($request->fabricViewModel["fabricName"]);
        $this->setIp($request->ip());
        $this->setModifiedBy($request->modifiedBy);

        return $this->fabricUseCase->save($this);
    }

    public function update(Request $request) : CustomResponse
    {
        $inputValidationResponse = $this->checkInputValidation($request->fabricViewModel,[
            'fabricName' => 'required|string'
        ]);

        if($inputValidationResponse != CustomResponseMsg::OK->value){
            return (new CustomResponse())->setResponse(CustomResponseCode::ERROR->value, $inputValidationResponse);
        }

        $this->setId($request->fabricViewModel["id"]);
        $this->setFabricName($request->fabricViewModel["fabricName"]);
        $this->setIp($request->ip());
        $this->setModifiedBy($request->modifiedBy);

        return $this->fabricUseCase->update($this);
    }

    public function remove(Request $request) : CustomResponse
    {
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
