<?php

namespace App\Enums;

enum CustomResponseCode : int
{
    case NEUTRAL = 0;
    case ERROR = 2;
    case SUCCESS = 3;
}
