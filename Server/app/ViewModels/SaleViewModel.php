<?php

namespace App\ViewModels;

class SaleViewModel extends BaseViewModel
{
    public ?string $billNumber;
    public int $singlePrice;
    public int $vatPercentage;
    public int $productCode;
    public int $productQuantity;

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
}
