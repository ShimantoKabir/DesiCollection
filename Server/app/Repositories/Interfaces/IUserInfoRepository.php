<?php

namespace App\Repositories\Interfaces;

use App\Models\CustomResponse;
use App\ViewModels\UserInfoViewModel;

interface IUserInfoRepository extends  IBaseRepository
{
    public function checkUserPermission(UserInfoViewModel $userInfoViewModel) : CustomResponse;
}
