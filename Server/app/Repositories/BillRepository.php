<?php

namespace App\Repositories;

use App\Enums\CustomResponseCode;
use App\Enums\CustomResponseMsg;
use App\Models\CustomResponse;
use App\Repositories\Interfaces\IBillRepository;
use App\ViewModels\AgeViewModel;
use App\ViewModels\BillViewModel;

class BillRepository extends BaseRepository implements IBillRepository
{

    /**
     * @return array
     */
    public function read(): array
    {
        return [];
    }

    /**
     * @return CustomResponse
     */
    public function getIndexData(): CustomResponse
    {
        $response = new CustomResponse();
        $response->setMsg(CustomResponseMsg::SUCCESS->value);
        $response->setCode(CustomResponseCode::SUCCESS->value);
        return $response;
    }


    /**
     * @param BillViewModel $billViewModel
     * @return CustomResponse
     */
    public function create(BillViewModel $billViewModel): CustomResponse
    {
        $response = new CustomResponse();
        $response->setMsg(CustomResponseMsg::SUCCESS->value);
        $response->setCode(CustomResponseCode::SUCCESS->value);
        return $response;
    }

    /**
     * @param BillViewModel $billViewModel
     * @return CustomResponse
     */
    public function update(BillViewModel $billViewModel): CustomResponse
    {
        $response = new CustomResponse();
        $response->setMsg(CustomResponseMsg::SUCCESS->value);
        $response->setCode(CustomResponseCode::SUCCESS->value);
        return $response;
    }
}
