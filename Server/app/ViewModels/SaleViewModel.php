<?php

namespace App\ViewModels;

use App\Enums\CustomResponseCode;
use App\Enums\CustomResponseMsg;
use App\Models\CustomResponse;
use App\UseCases\SaleUseCase;
use Illuminate\Http\Request;

class SaleViewModel extends BaseViewModel
{
    public ?string $billNumber;
    public int $singlePrice;
    public int $vatPercentage;
    public int $productCode;
    public int $productQuantity;
    private SaleUseCase $saleUseCase;

    public function __construct(SaleUseCase $saleUseCase)
    {
        $this->saleUseCase = $saleUseCase;
    }

    /**
     * @return string|null
     */
    public function getBillNumber(): ?string
    {
        return $this->billNumber;
    }

    /**
     * @param string|null $billNumber
     */
    public function setBillNumber(?string $billNumber): void
    {
        $this->billNumber = $billNumber;
    }

    /**
     * @param int $singlePrice
     */
    public function setSinglePrice(int $singlePrice): void
    {
        $this->singlePrice = $singlePrice;
    }

    /**
     * @return int
     */
    public function getSinglePrice(): int
    {
        return $this->singlePrice;
    }

    /**
     * @param int $vatPercentage
     */
    public function setVatPercentage(int $vatPercentage): void
    {
        $this->vatPercentage = $vatPercentage;
    }

    /**
     * @return int
     */
    public function getVatPercentage(): int
    {
        return $this->vatPercentage;
    }

    /**
     * @param int $productQuantity
     */
    public function setProductQuantity(int $productQuantity): void
    {
        $this->productQuantity = $productQuantity;
    }

    /**
     * @return int
     */
    public function getProductQuantity(): int
    {
        return $this->productQuantity;
    }

    /**
     * @param int $productCode
     */
    public function setProductCode(int $productCode): void
    {
        $this->productCode = $productCode;
    }

    /**
     * @return int
     */
    public function getProductCode(): int
    {
        return $this->productCode;
    }

    public function getSalesByBillNumber(Request $request) : CustomResponse
    {

        $saleViewModel = $request->saleViewModel;

        $saleValidationResponse = $this->checkInputValidation($saleViewModel,[
            'billNumber' => 'required|string'
        ]);

        if($saleValidationResponse != CustomResponseMsg::OK->value){
            return (new CustomResponse())->setResponse(CustomResponseCode::ERROR->value, $saleValidationResponse);
        }

        $this->setBillNumber($saleViewModel["billNumber"]);

        return $this->saleUseCase->getSalesByBillNumber($this);
    }
}
