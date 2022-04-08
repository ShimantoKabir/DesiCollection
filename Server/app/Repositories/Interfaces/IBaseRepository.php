<?php

namespace App\Repositories\Interfaces;

use Illuminate\Http\Request;

interface IBaseRepository
{
    public function getIndexData(Request $request);
    public function create(Request $request);
    public function read(Request $request);
    public function update(Request $request);
    public function delete(Request $request);
}
