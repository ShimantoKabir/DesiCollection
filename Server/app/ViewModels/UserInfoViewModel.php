<?php

namespace App\ViewModels;

class UserInfoViewModel extends BaseViewModel
{
    public int $id;
    public string $email;
    public string $token;
    public int $forWhom;
    public int $roleOid;
    public string $password;
    public string $lastName;
    public string $opAccess;
    public string $userName;
    public bool $isActive;
    public string $sessionId;
    public string $firstName;
    public bool $isApproved;
    public string $mobileNumber;
    public string $socialLoginId;
    public string $restrictedMenuOid;
    public string $ip;
    public int $modifiedBy;
    public string $operation;
    public string $href;

}
