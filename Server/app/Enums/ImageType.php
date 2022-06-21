<?php

namespace App\Enums;

enum ImageType : int
{
    case DEFAULT = 0;
    case PRODUCT = 1;
    case USER = 2;
    case BRAND = 3;
    case COLOR = 4;
}
