<?php

namespace App\ViewModels;

use App\Enums\CustomResponseCode;
use App\Enums\CustomResponseMsg;
use App\Models\CustomResponse;
use App\UseCases\SupplierUseCase;
use Illuminate\Http\Request;

class SupplierViewModel extends BaseViewModel
{
    public ?string $supplierName;
    public ?string $ip;
    public SupplierUseCase $supplierUseCase;

    /**
     * @return string|null
     */
    public function getSupplierName(): ?string
    {
        return $this->supplierName;
    }

    /**
     * @param string|null $supplierName
     */
    public function setSupplierName(?string $supplierName): void
    {
        $this->supplierName = $supplierName;
    }

    public function __construct(SupplierUseCase $supplierUseCase)
    {
        $this->supplierUseCase = $supplierUseCase;
    }

    public function getIndexData(Request $request) : CustomResponse
    {
        return $this->supplierUseCase->getIndexData($this);
    }

    public function save(Request $request) : CustomResponse
    {
        $supplierInputValidationResponse = $this->checkInputValidation($request->supplierViewModel,[
            'supplierName' => 'required|string'
        ]);

        if($supplierInputValidationResponse != CustomResponseMsg::OK->value){
            return (new CustomResponse())->setResponse(CustomResponseCode::ERROR->value, $supplierInputValidationResponse);
        }

        $this->setSupplierName($request->supplierViewModel["supplierName"]);
        $this->setIp($request->ip());
        $this->setModifiedBy(0);

        return $this->supplierUseCase->save($this);
    }

    public function update(Request $request) : CustomResponse
    {

        $supplierInputValidationResponse = $this->checkInputValidation($request->supplierViewModel,[
            'supplierName' => 'required|string'
        ]);

        if($supplierInputValidationResponse != CustomResponseMsg::OK->value){
            return (new CustomResponse())->setResponse(CustomResponseCode::ERROR->value, $supplierInputValidationResponse);
        }

        $this->setId($request->supplierViewModel["id"]);
        $this->setSupplierName($request->supplierViewModel["supplierName"]);
        $this->setIp($request->ip());
        $this->setModifiedBy(0);

        return $this->supplierUseCase->update($this);
    }

    public function remove(Request $request) : CustomResponse
    {
        $inputValidationResponse = $this->checkInputValidation($request->supplierViewModel,[
            'id' => 'required|int'
        ]);

        if($inputValidationResponse != CustomResponseMsg::OK->value){
            return (new CustomResponse())->setResponse(CustomResponseCode::ERROR->value, $inputValidationResponse);
        }

        $this->setId($request->supplierViewModel["id"]);
        return $this->supplierUseCase->remove($this);
    }

}
