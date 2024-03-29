<?php

namespace App\Repositories;

use App\Enums\CustomResponseCode;
use App\Enums\CustomResponseMsg;
use App\Models\Bill;
use App\Models\CustomResponse;
use App\Models\Product;
use App\Repositories\Interfaces\IBillRepository;
use App\ViewModels\AgeViewModel;
use App\ViewModels\BillViewModel;
use Exception;
use Illuminate\Support\Facades\DB;

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

        $res = new CustomResponse();
        DB::beginTransaction();
        try{

            $model = new Bill();
            $model->number = "BN".time();
            $model->customerId = $billViewModel->getCustomerId();
            $model->givenPrice = $billViewModel->getGivenPrice();
            $model->ip = $billViewModel->getIp();
            $model->createdAt = $billViewModel->getDate();
            $model->modifiedBy = $billViewModel->getModifiedBy();
            $model->save();

            $res->setModel($model);
            $res->setCode(CustomResponseCode::SUCCESS->value);
            $res->setMsg(CustomResponseMsg::SUCCESS->value);

            DB::commit();

        }catch (\Exception $e){
            DB::rollBack();
            $res->setCode(CustomResponseCode::ERROR->value);
            $res->setMsg($e->getMessage());
        }

        return $res;
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

    public function getBills() : CustomResponse
    {
        $response = new CustomResponse();
        $response->setMsg(CustomResponseMsg::SUCCESS->value);
        $response->setCode(CustomResponseCode::SUCCESS->value);

        $billPaginateRes = DB::table('bills AS b')
            ->join('user_infos AS c', 'c.id', '=', 'b.customerId')
            ->join('user_infos AS u', 'u.id', '=', 'b.modifiedBy')
            ->select(
                'b.number',
                'b.customerId',
                'b.givenPrice',
                'b.isActive',
                'b.replaceBy',
                'b.createdAt',
                DB::raw("c.mobile_number AS mobileNumber"),
                DB::raw("c.first_name AS firstName"),
                DB::raw("IFNULL(u.first_name, IFNULL(u.mobile_number, u.email)) AS billedBy")
            )
            ->orderBy("b.id","desc")
            ->paginate(5);

        $response->setPaginator($billPaginateRes);
        return $response;
    }

    public function inActiveBillByNumber(BillViewModel $billViewModel) : CustomResponse
    {
        $res = new CustomResponse();
        DB::beginTransaction();
        try{
            Bill::where('number',$billViewModel->getNumber())
                ->update([
                    'isActive' => false,
                    'replaceBy' => $billViewModel->getReplaceBy()
                ]);

            DB::commit();

            $res->setCode(CustomResponseCode::SUCCESS->value);
            $res->setMsg(CustomResponseMsg::SUCCESS->value);

        }catch (Exception $e){
            DB::rollBack();
            $res->setCode(CustomResponseCode::ERROR->value);
            $res->setMsg($e->getMessage());
        }

        return $res;
    }
}
