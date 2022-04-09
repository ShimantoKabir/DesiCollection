<?php

namespace App\Repositories\Interfaces;

use App\Models\CustomRequest;
use App\Models\CustomResponse;
use Illuminate\Http\Request;

interface IBaseRepository
{
    public function getIndexData() : CustomResponse;
    public function create(CustomRequest $request) : CustomResponse;
    public function read(CustomRequest $request) : CustomResponse;
    public function update(CustomRequest $request) : CustomResponse;
    public function delete(CustomRequest $request) : CustomResponse;
}
