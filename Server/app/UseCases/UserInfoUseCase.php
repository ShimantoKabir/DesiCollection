<?php

namespace App\UseCases;

use App\Models\CustomResponse;
use App\Repositories\UserInfoRepository;
use App\ViewModels\UserInfoViewModel;

class UserInfoUseCase extends BaseUseCase
{
    private UserInfoRepository $userInfoRepository;

    public function __construct(UserInfoRepository $userInfoRepository)
    {
        $this->userInfoRepository = $userInfoRepository;
    }

    public function checkUserPermission(UserInfoViewModel $userInfoViewModel) : CustomResponse
    {
        return $this->userInfoRepository->checkUserPermission($userInfoViewModel);
    }

}
