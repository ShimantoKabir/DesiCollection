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
    case SIZE_NAME_EXIST = "Size name already exist!";
    case PRODUCT_USER_EXIST = "Product user already exist!";
    case BRAND_EXIST = "Brand already exist!";
    case AGE_EXIST = "Age already exist!";
    case ADDRESS_EXIST = "Address already exist!";
    case SUPPLIER_EXIST = "Supplier name already exist!";
    case OK = "OK";
}
