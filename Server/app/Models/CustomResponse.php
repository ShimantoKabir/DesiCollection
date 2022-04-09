<?php

namespace App\Models;

use App\Enums\CustomResponseCode;
use App\Enums\CustomResponseMsg;

class CustomResponse
{
    public int $code;
    public string $msg;
    public array $fabrics;
}
