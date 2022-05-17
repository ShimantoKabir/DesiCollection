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
}
