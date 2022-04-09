<?php

namespace App\Enums;

use Illuminate\Validation\Rules\Enum;

enum CustomResponseCode : int
{
    case NEUTRAL = 0;
    case ERROR = 2;
    case SUCCESS = 3;
}
