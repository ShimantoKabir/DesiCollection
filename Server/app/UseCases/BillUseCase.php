<?php

namespace App\UseCases;

use App\Enums\CustomResponseCode;
use App\Enums\CustomResponseMsg;
use App\Models\CustomResponse;
use App\Repositories\BillRepository;
use App\Repositories\UserInfoRepository;
use App\ViewModels\BillViewModel;

class BillUseCase extends BaseUseCase
{

    private UserInfoRepository $userInfoRepository;
    public BillRepository $billRepository;

    public function __construct(UserInfoRepository $userInfoRepository,BillRepository $billRepository)
    {
        $this->userInfoRepository = $userInfoRepository;
        $this->billRepository = $billRepository;
    }

    public function getIndexData(BillViewModel $billViewModel) : CustomResponse
    {
        $response = new CustomResponse();
        $response->setCode(CustomResponseCode::SUCCESS->value);
        $response->setMsg(CustomResponseMsg::OK->value);
        return $response;
    }



}
