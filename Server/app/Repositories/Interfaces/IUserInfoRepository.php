<?php

namespace App\Repositories\Interfaces;

use App\Models\CustomRequest;
use App\Models\CustomResponse;
use App\ViewModels\UserInfoViewModel;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Model;

interface IUserInfoRepository extends  IBaseRepository
{
    public function checkUserPermission(UserInfoViewModel $userInfoViewModel) : CustomResponse;
    public function getCustomers(int $perPage) : LengthAwarePaginator;
    public function saveCustomer(CustomRequest $customRequest) : CustomResponse;
    public function getCustomerDetailsByMobileNumber(string $mobileNumber) : Model|null;
}
