<?php

namespace App\Models;

use App\ViewModels\UserInfoViewModel;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

class CustomResponse
{
    public int $code;
    public string $msg;
    public array $fabrics;
    public array $sizes;
    public array $ages;
    public array $brands;
    public array $types;
    public array $userTypes;
    public int $modifiedBy;
    public object $model;
    public array $products;
    public array $colors;
    public array $supplierBills;
    public array $suppliers;
    public array $addresses;
    public ?object $address;
    public ?array $images;
    public LengthAwarePaginator $paginator;
    public ?int $vatPercentage;
    public ?int $singlePurchasePrice;
    public ?array $saleViewModels;
    public ?int $grandTotal;

    public function setResponse(int $code, string $msg) : CustomResponse
    {
        $this->code = $code;
        $this->msg = $msg;
        return $this;
    }

    /**
     * @return int|null
     */
    public function getGrandTotal(): ?int
    {
        return $this->grandTotal;
    }

    /**
     * @param int|null $grandTotal
     */
    public function setGrandTotal(?int $grandTotal): void
    {
        $this->grandTotal = $grandTotal;
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
     * @param int|null $vatPercentage
     */
    public function setVatPercentage(?int $vatPercentage): void
    {
        $this->vatPercentage = $vatPercentage;
    }

    /**
     * @return int|null
     */
    public function getVatPercentage(): ?int
    {
        return $this->vatPercentage;
    }

    /**
     * @param int|null $singlePurchasePrice
     */
    public function setSinglePurchasePrice(?int $singlePurchasePrice): void
    {
        $this->singlePurchasePrice = $singlePurchasePrice;
    }

    /**
     * @return int|null
     */
    public function getSinglePurchasePrice(): ?int
    {
        return $this->singlePurchasePrice;
    }

    /**
     * @param LengthAwarePaginator $paginator
     */
    public function setPaginator(LengthAwarePaginator $paginator): void
    {
        $this->paginator = $paginator;
    }

    /**
     * @return LengthAwarePaginator
     */
    public function getPaginator(): LengthAwarePaginator
    {
        return $this->paginator;
    }

    /**
     * @param array|null $images
     */
    public function setImages(?array $images): void
    {
        $this->images = $images;
    }

    /**
     * @return array|null
     */
    public function getImages(): ?array
    {
        return $this->images;
    }

    public function setCode(int $code){
        $this->code = $code;
    }

    public function setMsg(string $msg){
        $this->msg = $msg;
    }

    public function setModel(object $model){
        $this->model = $model;
    }

    public function setFabrics(array $fabrics){
        $this->fabrics = $fabrics;
    }

    public function setSizes(array $sizes){
        $this->sizes = $sizes;
    }

    public function setAges(array $ages){
        $this->ages = $ages;
    }

    public function setBrands(array $brands){
        $this->brands = $brands;
    }

    public function getBrands() : array
    {
        return $this->ages;
    }

    public function getModel() : object
    {
        return $this->model;
    }

    public function setTypes(array $types){
        $this->types = $types;
    }

    public function getTypes() : array
    {
        return $this->types;
    }

    public function setUserTypes(array $userTypes){
        $this->userTypes = $userTypes;
    }

    public function getUserTypes() : array
    {
        return $this->userTypes;
    }

    /**
     * @return array
     */
    public function getProducts(): array
    {
        return $this->products;
    }

    /**
     * @param array $products
     */
    public function setProducts(array $products): void
    {
        $this->products = $products;
    }

    /**
     * @param array $colors
     */
    public function setColors(array $colors): void
    {
        $this->colors = $colors;
    }

    /**
     * @return array
     */
    public function getColors(): array
    {
        return $this->colors;
    }

    /**
     * @return int
     */
    public function getCode(): int
    {
        return $this->code;
    }

    /**
     * @param int $modifiedBy
     */
    public function setModifiedBy(int $modifiedBy): void
    {
        $this->modifiedBy = $modifiedBy;
    }

    /**
     * @return int
     */
    public function getModifiedBy(): int
    {
        return $this->modifiedBy;
    }

    /**
     * @return array
     */
    public function getAges(): array
    {
        return $this->ages;
    }

    /**
     * @return array
     */
    public function getFabrics(): array
    {
        return $this->fabrics;
    }

    /**
     * @return string
     */
    public function getMsg(): string
    {
        return $this->msg;
    }

    /**
     * @return array
     */
    public function getSizes(): array
    {
        return $this->sizes;
    }

    /**
     * @return array
     */
    public function getSupplierBills(): array
    {
        return $this->supplierBills;
    }

    /**
     * @param array $supplierBills
     */
    public function setSupplierBills(array $supplierBills): void
    {
        $this->supplierBills = $supplierBills;
    }

    /**
     * @return array
     */
    public function getSuppliers(): array
    {
        return $this->suppliers;
    }

    /**
     * @param array $suppliers
     */
    public function setSuppliers(array $suppliers): void
    {
        $this->suppliers = $suppliers;
    }

    /**
     * @return object|null
     */
    public function getAddress(): ?object
    {
        return $this->address;
    }

    /**
     * @param object|null $address
     */
    public function setAddress(?object $address): void
    {
        $this->address = $address;
    }


    /**
     * @return array
     */
    public function getAddresses(): array
    {
        return $this->addresses;
    }

    /**
     * @param array $addresses
     */
    public function setAddresses(array $addresses): void
    {
        $this->addresses = $addresses;
    }

}
