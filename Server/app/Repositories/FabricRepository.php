<?php

namespace App\Repositories;

use App\Models\CustomResponse;
use App\Repositories\Interfaces\IFabricRepository;
use Illuminate\Http\Request;

class FabricRepository extends BaseRepository implements IFabricRepository
{

    public function getIndexData(Request $request) : CustomResponse
    {
        $this->customResponse->code = 200;
        $this->customResponse->msg = "hi";

        return $this->customResponse;
    }

    public function create(Request $request)
    {
        // TODO: Implement create() method.
    }

    public function read(Request $request)
    {
        // TODO: Implement read() method.
    }

    public function update(Request $request)
    {
        // TODO: Implement update() method.
    }

    public function delete(Request $request)
    {
        // TODO: Implement delete() method.
    }
}
