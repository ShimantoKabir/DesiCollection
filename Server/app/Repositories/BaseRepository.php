<?php

namespace App\Repositories;

use App\Models\CustomResponse;

class BaseRepository
{
    public CustomResponse $customResponse;

    public function __construct(CustomResponse $customResponse)
    {
        $this->customResponse = $customResponse;
    }

}
