<?php

namespace App\Repositories\Interfaces;

use App\Models\CustomResponse;
use App\ViewModels\AddressViewModel;

interface IAddressRepository extends IBaseRepository
{
    public function readByLinkUpId(int $linkUpId) : array;
    public function create(AddressViewModel $addressViewModel) : CustomResponse;
    public function update(AddressViewModel $addressViewModel) : CustomResponse;
    public function delete(AddressViewModel $addressViewModel) : CustomResponse;
    public function isAddressExist(AddressViewModel $addressViewModel) : CustomResponse;
}
