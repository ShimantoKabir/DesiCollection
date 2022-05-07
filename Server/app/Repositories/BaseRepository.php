<?php

namespace App\Repositories;

class BaseRepository
{

    public function getCurrentDate() : string
    {
        return date('Y-m-d H:i:s');
    }

}
