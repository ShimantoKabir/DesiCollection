<?php

namespace App\ViewModels;

class BillViewModel extends BaseViewModel
{
    public ?string $number;
    public ?int $customerId;
    public int $givenPrice;
    public int $singlePrice;
    public int $vatPercentage;
    public int $productCode;
    public int $productQuantity;
    public ?bool $isActive;
    public ?string $firstName;
    public ?string $mobileNumber;

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
     * @return int
     */
    public function getGivenPrice(): int
    {
        return $this->givenPrice;
    }

    /**
     * @param int $givenPrice
     */
    public function setGivenPrice(int $givenPrice): void
    {
        $this->givenPrice = $givenPrice;
    }

    /**
     * @return int
     */
    public function getSinglePrice(): int
    {
        return $this->singlePrice;
    }

    /**
     * @param int $singlePrice
     */
    public function setSinglePrice(int $singlePrice): void
    {
        $this->singlePrice = $singlePrice;
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
     * @return int
     */
    public function getProductCode(): int
    {
        return $this->productCode;
    }

    /**
     * @param int $productCode
     */
    public function setProductCode(int $productCode): void
    {
        $this->productCode = $productCode;
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




}
