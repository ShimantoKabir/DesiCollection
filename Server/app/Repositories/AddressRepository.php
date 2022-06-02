<?php

namespace App\Repositories;

use App\Enums\AddressType;
use App\Enums\CustomResponseCode;
use App\Enums\CustomResponseMsg;
use App\Models\Address;
use App\Models\CustomResponse;
use App\Repositories\Interfaces\IAddressRepository;
use App\ViewModels\AddressViewModel;
use Illuminate\Support\Facades\DB;

class AddressRepository extends BaseRepository implements IAddressRepository
{

    public function read(): array
    {
        return Address::select(
            'id',
            'city',
            'email',
            'detail',
            'country',
            'zipCode',
            'linkUpId',
            'addressType',
            'firstMobileNo',
            'secondMobileNo',
        )->get()->toArray();
    }


    public function readByLinkUpIdAndType(int $linkUpId,string $addressType): array
    {
        return Address::select(
            'id',
            'city',
            'email',
            'detail',
            'country',
            'zipCode',
            'linkUpId',
            'addressType',
            'firstMobileNo',
            'secondMobileNo',
        )
        ->where("linkUpId",$linkUpId)
        ->where("addressType",$addressType)
        ->get()
        ->toArray();
    }

    public function create(AddressViewModel $addressViewModel): CustomResponse
    {
        $date = $this->getCurrentDate();
        $res = new CustomResponse();
        DB::beginTransaction();
        try{

            $model = new Address();
            $model->city = $addressViewModel->getCity();
            $model->email = $addressViewModel->getEmail();
            $model->detail = $addressViewModel->getDetail();
            $model->country = $addressViewModel->getCountry();
            $model->zipCode = $addressViewModel->getZipCode();
            $model->linkUpId = $addressViewModel->getLinkUpId();
            $model->addressType = $addressViewModel->getAddressType();
            $model->firstMobileNo = $addressViewModel->getFirstMobileNo();
            $model->secondMobileNo = $addressViewModel->getSecondMobileNo();
            $model->ip = $addressViewModel->getIp();
            $model->modifiedBy = $addressViewModel->getModifiedBy();
            $model->createdAt = $date;
            $model->save();

            $res->setModel($model);
            $res->setCode(CustomResponseCode::SUCCESS->value);
            $res->setMsg(CustomResponseMsg::SUCCESS->value);

            DB::commit();

        }catch (\Exception $e){
            $res->setCode(CustomResponseCode::ERROR->value);
            $res->setMsg($e->getMessage());
        }

        return $res;
    }

    public function update(AddressViewModel $addressViewModel): CustomResponse
    {
        $date = $this->getCurrentDate();
        $res = new CustomResponse();
        DB::beginTransaction();
        try{

            Address::where('id',$addressViewModel->getId())
                ->update([
                    'city' => $addressViewModel->getCity(),
                    'email' => $addressViewModel->getEmail(),
                    'detail' => $addressViewModel->getDetail(),
                    'country' => $addressViewModel->getCountry(),
                    'zipCode' => $addressViewModel->getZipCode(),
                    'firstMobileNo' => $addressViewModel->getFirstMobileNo(),
                    'secondMobileNo' => $addressViewModel->getSecondMobileNo(),
                    'ip' => $addressViewModel->getIp(),
                    'modifiedBy' => $addressViewModel->getModifiedBy(),
                    'updatedAt' => $date
                ]);

            DB::commit();
            $res->setCode(CustomResponseCode::SUCCESS->value);
            $res->setMsg(CustomResponseMsg::SUCCESS->value);

        }catch (\Exception $e){
            $res->setCode(CustomResponseCode::ERROR->value);
            $res->setMsg($e->getMessage());
        }

        return $res;
    }

    public function delete(AddressViewModel $addressViewModel): CustomResponse
    {
        $res = new CustomResponse();
        DB::beginTransaction();
        try{

            Address::where('linkUpId',$addressViewModel->getLinkUpId())->delete();
            DB::commit();

            $res->setCode(CustomResponseCode::SUCCESS->value);
            $res->setMsg(CustomResponseMsg::SUCCESS->value);

        }catch (\Exception $e){
            $res->setCode(CustomResponseCode::ERROR->value);
            $res->setMsg($e->getMessage());
        }

        return $res;
    }

    public function isAddressExist(AddressViewModel $addressViewModel): CustomResponse
    {
        $res = new CustomResponse();
        $isExist = Address::where('city',$addressViewModel->getCity())
            ->where('email',$addressViewModel->getEmail())
            ->where('country',$addressViewModel->getCountry())
            ->where('zipCode',$addressViewModel->getZipCode())
            ->where('firstMobileNo',$addressViewModel->getFirstMobileNo())
            ->where('secondMobileNo',$addressViewModel->getSecondMobileNo())
            ->where('addressType',$addressViewModel->getAddressType())
            ->exists();

        if($isExist){
            $res->setCode(CustomResponseCode::ERROR->value);
            $res->setMsg(CustomResponseMsg::ADDRESS_EXIST->value);
        }else{
            $res->setCode(CustomResponseCode::SUCCESS->value);
            $res->setMsg(CustomResponseMsg::SUCCESS->value);
        }

        return $res;
    }
}
