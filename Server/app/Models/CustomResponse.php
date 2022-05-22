<?php

namespace App\Models;

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

    public function setResponse(int $code, string $msg) : CustomResponse
    {
        $this->code = $code;
        $this->msg = $msg;
        return $this;
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

}
