<?php

namespace App\Enums;

enum CustomResponseMsg : string
{
    case ERROR = "Something went wrong, please try again!";
    case SUCCESS = "Operation successful!";
    case AUTH_SUCCESS = "Authentication successful!";
    case AUTH_ERROR = "Authentication failed!";
}
