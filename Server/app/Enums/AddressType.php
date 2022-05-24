<?php

namespace App\Enums;

enum AddressType : int
{
    case DEFAULT = 0;
    case SUPPLIER = 1;
    case DELIVERY = 2;
    case BILLING = 3;
    case USER = 4;
}
