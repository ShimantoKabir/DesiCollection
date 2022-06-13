<?php

namespace App\ViewModels;

use App\Enums\CustomResponseCode;
use App\Enums\CustomResponseMsg;
use App\Models\CustomResponse;
use App\UseCases\SupplierAddressUseCase;
use Illuminate\Http\Request;

class SupplierAddressViewModel extends BaseViewModel
{
    public string $city;
    public string $email;
    public ?string $detail;
    public ?string $country;
    public string $zipCode;
    public ?int $addressType;
    public ?int $linkUpId;
    public string $firstMobileNo;
    public ?string $secondMobileNo;
    public ?int $supplierId;
    public ?string $supplierName;
    public SupplierAddressUseCase $supplierAddressUseCase;

    /**
     * @return string
     */
    public function getCity(): string
    {
        return $this->city;
    }

    /**
     * @param string $city
     */
    public function setCity(string $city): void
    {
        $this->city = $city;
    }

    /**
     * @return string
     */
    public function getEmail(): string
    {
        return $this->email;
    }

    /**
     * @param string $email
     */
    public function setEmail(string $email): void
    {
        $this->email = $email;
    }

    /**
     * @return string|null
     */
    public function getDetail(): ?string
    {
        return $this->detail;
    }

    /**
     * @param string|null $detail
     */
    public function setDetail(?string $detail): void
    {
        $this->detail = $detail;
    }

    /**
     * @return string|null
     */
    public function getCountry(): ?string
    {
        return $this->country;
    }

    /**
     * @param string|null $country
     */
    public function setCountry(?string $country): void
    {
        $this->country = $country;
    }

    /**
     * @return string
     */
    public function getZipCode(): string
    {
        return $this->zipCode;
    }

    /**
     * @param string $zipCode
     */
    public function setZipCode(string $zipCode): void
    {
        $this->zipCode = $zipCode;
    }

    /**
     * @return int|null
     */
    public function getAddressType(): ?int
    {
        return $this->addressType;
    }

    /**
     * @param int|null $addressType
     */
    public function setAddressType(?int $addressType): void
    {
        $this->addressType = $addressType;
    }

    /**
     * @return int|null
     */
    public function getLinkUpId(): ?int
    {
        return $this->linkUpId;
    }

    /**
     * @param int|null $linkUpId
     */
    public function setLinkUpId(?int $linkUpId): void
    {
        $this->linkUpId = $linkUpId;
    }

    /**
     * @return string
     */
    public function getFirstMobileNo(): string
    {
        return $this->firstMobileNo;
    }

    /**
     * @param string $firstMobileNo
     */
    public function setFirstMobileNo(string $firstMobileNo): void
    {
        $this->firstMobileNo = $firstMobileNo;
    }

    /**
     * @return string|null
     */
    public function getSecondMobileNo(): ?string
    {
        return $this->secondMobileNo;
    }

    /**
     * @param string|null $secondMobileNo
     */
    public function setSecondMobileNo(?string $secondMobileNo): void
    {
        $this->secondMobileNo = $secondMobileNo;
    }

    /**
     * @return int|null
     */
    public function getSupplierId(): ?int
    {
        return $this->supplierId;
    }

    /**
     * @param int|null $supplierId
     */
    public function setSupplierId(?int $supplierId): void
    {
        $this->supplierId = $supplierId;
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

    public function __construct(SupplierAddressUseCase $supplierAddressUseCase)
    {
        $this->supplierAddressUseCase = $supplierAddressUseCase;
    }

    public function getIndexData(Request $request) : CustomResponse
    {
        return $this->supplierAddressUseCase->getIndexData($this);
    }

    public function save(Request $request) : CustomResponse
    {
        $inputValidationResponse = $this->checkInputValidation($request->supplierAddressViewModel,[
            'city' => 'required|string',
            'email' => 'required|string',
            'country' => 'required|string',
            'zipCode' => 'required|string',
            'supplierId' => 'required|int',
            'firstMobileNo' => 'required|string'
        ]);

        if($inputValidationResponse != CustomResponseMsg::OK->value){
            return (new CustomResponse())->setResponse(CustomResponseCode::ERROR->value, $inputValidationResponse);
        }

        $this->setCity($request->supplierAddressViewModel["city"]);
        $this->setEmail($request->supplierAddressViewModel["email"]);
        $this->setCountry($request->supplierAddressViewModel["country"]);
        $this->setZipCode($request->supplierAddressViewModel["zipCode"]);
        $this->setFirstMobileNo($request->supplierAddressViewModel["firstMobileNo"]);
        $this->setSecondMobileNo($request->supplierAddressViewModel["secondMobileNo"]);
        $this->setDetail($request->supplierAddressViewModel["detail"]);
        $this->setSupplierId($request->supplierAddressViewModel["supplierId"]);
        $this->setIp($request->ip());
        $this->setModifiedBy($request->modifiedBy);

        return $this->supplierAddressUseCase->save($this);

    }

    public function update(Request $request) : CustomResponse
    {
        $inputValidationResponse = $this->checkInputValidation($request->supplierAddressViewModel,[
            'id' => 'required|int',
            'city' => 'required|string',
            'email' => 'required|string',
            'country' => 'required|string',
            'zipCode' => 'required|string',
            'supplierId' => 'required|int',
            'supplierName' => 'required|string',
            'firstMobileNo' => 'required|string'
        ]);

        if($inputValidationResponse != CustomResponseMsg::OK->value){
            return (new CustomResponse())->setResponse(CustomResponseCode::ERROR->value, $inputValidationResponse);
        }

        $this->setId($request->supplierAddressViewModel["id"]);
        $this->setCity($request->supplierAddressViewModel["city"]);
        $this->setEmail($request->supplierAddressViewModel["email"]);
        $this->setDetail($request->supplierAddressViewModel["detail"]);
        $this->setCountry($request->supplierAddressViewModel["country"]);
        $this->setZipCode($request->supplierAddressViewModel["zipCode"]);
        $this->setSupplierId($request->supplierAddressViewModel["supplierId"]);
        $this->setSupplierName($request->supplierAddressViewModel["supplierName"]);
        $this->setFirstMobileNo($request->supplierAddressViewModel["firstMobileNo"]);
        $this->setSecondMobileNo($request->supplierAddressViewModel["secondMobileNo"]);
        $this->setIp($request->ip());
        $this->setModifiedBy($request->modifiedBy);

        return $this->supplierAddressUseCase->update($this);
    }

    public function remove(Request $request) : CustomResponse
    {
        $inputValidationResponse = $this->checkInputValidation($request->supplierAddressViewModel,[
            'id' => 'required|int'
        ]);

        if($inputValidationResponse != CustomResponseMsg::OK->value){
            return (new CustomResponse())->setResponse(CustomResponseCode::ERROR->value, $inputValidationResponse);
        }

        $this->setId($request->supplierAddressViewModel["id"]);
        return $this->supplierAddressUseCase->remove($this);
    }

}
