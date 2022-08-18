<?php

namespace App\ViewModels;

use App\Enums\CustomResponseCode;
use App\Enums\CustomResponseMsg;
use App\Models\CustomResponse;
use App\UseCases\BillUseCase;
use Illuminate\Http\Request;

class BillViewModel extends BaseViewModel
{
    public ?string $number;
    public ?int $customerId;
    public ?int $givenPrice;
    public ?bool $isActive;
    public ?string $firstName;
    public ?string $mobileNumber;
    public SaleViewModel $saleViewModel;
    public BillUseCase $billUseCase;
    public ?array $saleViewModels;

    public function __construct(BillUseCase $billUseCase)
    {
        $this->billUseCase = $billUseCase;
    }

    /**
     * @return array|null
     */
    public function getSaleViewModels(): ?array
    {
        return $this->saleViewModels;
    }

    /**
     * @param array|null $saleViewModels
     */
    public function setSaleViewModels(?array $saleViewModels): void
    {
        $this->saleViewModels = $saleViewModels;
    }

    /**
     * @return string|null
     */
    public function getNumber(): ?string
    {
        return $this->number;
    }

    /**
     * @param string|null $number
     */
    public function setNumber(?string $number): void
    {
        $this->number = $number;
    }

    /**
     * @return int|null
     */
    public function getCustomerId(): ?int
    {
        return $this->customerId;
    }

    /**
     * @param int|null $customerId
     */
    public function setCustomerId(?int $customerId): void
    {
        $this->customerId = $customerId;
    }

    /**
     * @param int|null $givenPrice
     */
    public function setGivenPrice(?int $givenPrice): void
    {
        $this->givenPrice = $givenPrice;
    }

    /**
     * @return int|null
     */
    public function getGivenPrice(): ?int
    {
        return $this->givenPrice;
    }

    /**
     * @return bool|null
     */
    public function getIsActive(): ?bool
    {
        return $this->isActive;
    }

    /**
     * @param bool|null $isActive
     */
    public function setIsActive(?bool $isActive): void
    {
        $this->isActive = $isActive;
    }

    /**
     * @param string|null $mobileNumber
     */
    public function setMobileNumber(?string $mobileNumber): void
    {
        $this->mobileNumber = $mobileNumber;
    }

    /**
     * @return string|null
     */
    public function getMobileNumber(): ?string
    {
        return $this->mobileNumber;
    }

    /**
     * @return SaleViewModel
     */
    public function getSaleViewModel(): SaleViewModel
    {
        return $this->saleViewModel;
    }

    /**
     * @param SaleViewModel $saleViewModel
     */
    public function setSaleViewModel(SaleViewModel $saleViewModel): void
    {
        $this->saleViewModel = $saleViewModel;
    }

    public function getIndexData(Request $request) : CustomResponse
    {
        return $this->billUseCase->getIndexData($this);
    }

    public function calculate(Request $request) : CustomResponse
    {

        $billViewModel = $request->billViewModel;

        $inputValidationResponse = $this->checkInputValidation($billViewModel,[
            'salesViewModels.*.productCode' => 'required|string',
            'salesViewModels.*.productQuantity' => 'required|integer|min:1'
        ]);

        if($inputValidationResponse != CustomResponseMsg::OK->value){
            return (new CustomResponse())->setResponse(CustomResponseCode::ERROR->value, $inputValidationResponse);
        }else{
            return (new CustomResponse())->setResponse(CustomResponseCode::SUCCESS->value, $inputValidationResponse);
        }

    }


}
