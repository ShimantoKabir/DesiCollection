<?php

namespace App\Models;

use phpDocumentor\Reflection\Project;

class CustomResponse
{
    public int $code;
    public string $msg;
    public array $fabrics;
    public int $modifiedBy;
    public object $model;

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

    public function setModifiedBy(int $modifiedBy){
        $this->modifiedBy = $modifiedBy;
    }

    public function getModel() : object
    {
        return $this->model;
    }
}
