<?php

namespace App\Enums;

enum CustomResponseMsg : string
{
    case ERROR = "Something went wrong, please try again!";
    case SUCCESS = "Operation successful!";
    case INIT_SUCCESS = "Initial data fetched successfully!";
    case AUTH_SUCCESS = "Authentication successful!";
    case AUTH_ERROR = "Authentication failed!";
    case FABRIC_NAME_EXIST = "Fabric name already exist!";
}
