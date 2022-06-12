<?php

namespace App\Enums;

enum HttpRequestType : string
{
    case GET = "GET";
    case POST = "POST";
    case PUT = "PUT";
    case DELETE = "DELETE";
}
