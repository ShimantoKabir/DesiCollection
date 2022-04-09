<?php

namespace App\Enums;

enum OperationType : string
{
    case CREATE = "C";
    case READ = "R";
    case UPDATE = "U";
    case DELETE = "D";
}
