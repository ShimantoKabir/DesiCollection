<?php

namespace App\ViewModels;

use App\Enums\CustomResponseCode;
use App\Enums\CustomResponseMsg;
use App\Enums\OperationType;
use App\Models\CustomResponse;
use App\UseCases\SupplierUseCase;
use Illuminate\Http\Request;

class SupplierViewModel extends BaseViewModel
{

    public ?int $id;
    public ?string $supplierName;
    public ?string $ip;
    public ?string $createdAt;
    public ?string $updatedAt;
    public ?int $modifiedBy;
    public ?AddressViewModel $addressViewModel;
    public SupplierUseCase $supplierUseCase;

    /**
     * @return int|null
     */
    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * @param int|null $id
     */
    public function setId(?int $id): void
    {
        $this->id = $id;
    }

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

    /**
     * @return string|null
     */
    public function getIp(): ?string
    {
        return $this->ip;
    }

    /**
     * @param string|null $ip
     */
    public function setIp(?string $ip): void
    {
        $this->ip = $ip;
    }

    /**
     * @param string|null $createdAt
     */
    public function setCreatedAt(?string $createdAt): void
    {
        $this->createdAt = $createdAt;
    }

    /**
     * @return string|null
     */
    public function getCreatedAt(): ?string
    {
        return $this->createdAt;
    }

    /**
     * @param string|null $updatedAt
     */
    public function setUpdatedAt(?string $updatedAt): void
    {
        $this->updatedAt = $updatedAt;
    }

    /**
     * @return string|null
     */
    public function getUpdatedAt(): ?string
    {
        return $this->updatedAt;
    }

    /**
     * @return int|null
     */
    public function getModifiedBy(): ?int
    {
        return $this->modifiedBy;
    }

    /**
     * @param int|null $modifiedBy
     */
    public function setModifiedBy(?int $modifiedBy): void
    {
        $this->modifiedBy = $modifiedBy;
    }

    /**
     * @return AddressViewModel|null
     */
    public function getAddressViewModel(): ?AddressViewModel
    {
        return $this->addressViewModel;
    }

    /**
     * @param AddressViewModel|null $addressViewModel
     */
    public function setAddressViewModel(?AddressViewModel $addressViewModel): void
    {
        $this->addressViewModel = $addressViewModel;
    }

    public function __construct(SupplierUseCase $supplierUseCase)
    {
        $this->supplierUseCase = $supplierUseCase;
    }

    public function getIndexData(Request $request) : CustomResponse
    {
        $authResponse = $this->checkAuthValidation($request,OperationType::READ);

        if($authResponse != CustomResponseMsg::OK->value){
            return (new CustomResponse())->setResponse(CustomResponseCode::ERROR->value, $authResponse);
        }

        return $this->supplierUseCase->getIndexData($this);
    }

    public function save(Request $request) : CustomResponse
    {
        $authResponse = $this->checkAuthValidation($request,OperationType::CREATE);

        if($authResponse != CustomResponseMsg::OK->value){
            return (new CustomResponse())->setResponse(CustomResponseCode::ERROR->value, $authResponse);
        }

        $supplierInputValidationResponse = $this->checkInputValidation($request->supplierViewModel,[
            'supplierName' => 'required|string'
        ]);

        if($supplierInputValidationResponse != CustomResponseMsg::OK->value){
            return (new CustomResponse())->setResponse(CustomResponseCode::ERROR->value, $supplierInputValidationResponse);
        }

        $addressInputValidationResponse = $this->checkInputValidation($request->supplierViewModel["addressViewModel"],[
            'city' => 'required|string',
            'email' => 'required|string',
            'country' => 'required|string',
            'zipCode' => 'required|string',
            'firstMobileNo' => 'required|string'
        ]);

        if($addressInputValidationResponse != CustomResponseMsg::OK->value){
            return (new CustomResponse())->setResponse(CustomResponseCode::ERROR->value, $addressInputValidationResponse);
        }

        $this->setSupplierName($request->supplierViewModel["supplierName"]);

        $addressViewModel = new AddressViewModel();
        $addressViewModel->setCity($request->supplierViewModel["addressViewModel"]["city"]);
        $addressViewModel->setEmail($request->supplierViewModel["addressViewModel"]["email"]);
        $addressViewModel->setDetail($request->supplierViewModel["addressViewModel"]["detail"]);
        $addressViewModel->setCountry($request->supplierViewModel["addressViewModel"]["country"]);
        $addressViewModel->setZipCode($request->supplierViewModel["addressViewModel"]["zipCode"]);
        $addressViewModel->setFirstMobileNo($request->supplierViewModel["addressViewModel"]["firstMobileNo"]);
        $addressViewModel->setSecondMobileNo($request->supplierViewModel["addressViewModel"]["secondMobileNo"]);
        $addressViewModel->setIp($request->ip());
        $addressViewModel->setModifiedBy(0);

        $this->setAddressViewModel($addressViewModel);
        $this->setIp($request->ip());
        $this->setModifiedBy(0);

        return $this->supplierUseCase->save($this);

    }

}
