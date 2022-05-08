<?php

namespace App\Models;

class CustomResponse
{
    public int $code;
    public string $msg;
    public array $fabrics;
    public array $sizes;
    public array $ages;
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

    public function setModifiedBy(int $modifiedBy){
        $this->modifiedBy = $modifiedBy;
    }

    public function getModel() : object
    {
        return $this->model;
    }
}
