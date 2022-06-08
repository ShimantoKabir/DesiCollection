<?php

namespace App\Repositories;

use App\Enums\AddressType;
use App\Enums\CustomResponseCode;
use App\Enums\CustomResponseMsg;
use App\Models\Address;
use App\Models\CustomResponse;
use App\Repositories\Interfaces\ISupplierAddressRepository;
use App\ViewModels\SupplierAddressViewModel;
use Illuminate\Support\Facades\DB;

class SupplierAddressRepository extends BaseRepository implements ISupplierAddressRepository
{
    /**
     * @param SupplierAddressViewModel $supplierAddressViewModel
     * @return CustomResponse
     */
    public function getIndexData(SupplierAddressViewModel $supplierAddressViewModel): CustomResponse
    {
        $customResponse = new CustomResponse();
        $addresses = DB::table('addresses')
            ->join('suppliers', 'addresses.linkUpId', '=', 'suppliers.id')
            ->select('addresses.*', 'suppliers.id AS supplierId', 'suppliers.supplierName')
            ->where("addresses.addressType",AddressType::SUPPLIER->value)
            ->get()
            ->toArray();

        $customResponse->setCode(CustomResponseCode::SUCCESS->value);
        $customResponse->setMsg(CustomResponseMsg::SUCCESS->value);
        $customResponse->setAddresses($addresses);

        return $customResponse;
    }

    /**
     * @param SupplierAddressViewModel $supplierAddressViewModel
     * @return CustomResponse
     */
    public function create(SupplierAddressViewModel $supplierAddressViewModel): CustomResponse
    {
        $date = $this->getCurrentDate();
        $res = new CustomResponse();

        DB::beginTransaction();
        try{

            $model = new Address();
            $model->city = $supplierAddressViewModel->getCity();
            $model->email = $supplierAddressViewModel->getEmail();
            $model->detail = $supplierAddressViewModel->getDetail();
            $model->country = $supplierAddressViewModel->getCountry();
            $model->zipCode = $supplierAddressViewModel->getZipCode();
            $model->linkUpId = $supplierAddressViewModel->getSupplierId();
            $model->addressType = AddressType::SUPPLIER->value;
            $model->firstMobileNo = $supplierAddressViewModel->getFirstMobileNo();
            $model->secondMobileNo = $supplierAddressViewModel->getSecondMobileNo();
            $model->ip = $supplierAddressViewModel->getIp();
            $model->modifiedBy = $supplierAddressViewModel->getModifiedBy();
            $model->createdAt = $date;
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
     * @param SupplierAddressViewModel $supplierAddressViewModel
     * @return CustomResponse
     */
    public function update(SupplierAddressViewModel $supplierAddressViewModel): CustomResponse
    {
        $date = $this->getCurrentDate();
        $res = new CustomResponse();

        DB::beginTransaction();
        try{

            Address::where('id',$supplierAddressViewModel->getId())
                ->update([
                    'city' => $supplierAddressViewModel->getCity(),
                    'email' => $supplierAddressViewModel->getEmail(),
                    'detail' => $supplierAddressViewModel->getDetail(),
                    'country' => $supplierAddressViewModel->getCountry(),
                    'zipCode' => $supplierAddressViewModel->getZipCode(),
                    'linkUpId' => $supplierAddressViewModel->getSupplierId(),
                    'firstMobileNo' => $supplierAddressViewModel->getFirstMobileNo(),
                    'secondMobileNo' => $supplierAddressViewModel->getSecondMobileNo(),
                    'ip' => $supplierAddressViewModel->getIp(),
                    'modifiedBy' => $supplierAddressViewModel->getModifiedBy(),
                    'updatedAt' => $date
                ]);

            DB::commit();
            $res->setCode(CustomResponseCode::SUCCESS->value);
            $res->setMsg(CustomResponseMsg::SUCCESS->value);

        }catch (\Exception $e){
            DB::rollBack();
            $res->setCode(CustomResponseCode::ERROR->value);
            $res->setMsg($e->getMessage());
        }

        return $res;
    }

    /**
     * @param SupplierAddressViewModel $supplierAddressViewModel
     * @return CustomResponse
     */
    public function delete(SupplierAddressViewModel $supplierAddressViewModel): CustomResponse
    {
        $res = new CustomResponse();
        DB::beginTransaction();
        try{

            Address::where('id',$supplierAddressViewModel->getId())->delete();
            DB::commit();

            $res->setCode(CustomResponseCode::SUCCESS->value);
            $res->setMsg(CustomResponseMsg::SUCCESS->value);

        }catch (\Exception $e){
            DB::rollBack();
            $res->setCode(CustomResponseCode::ERROR->value);
            $res->setMsg($e->getMessage());
        }

        return $res;
    }

    /**
     * @param SupplierAddressViewModel $supplierAddressViewModel
     * @return CustomResponse
     */
    public function isSupplierAddressExist(SupplierAddressViewModel $supplierAddressViewModel): CustomResponse
    {
        $res = new CustomResponse();

        $isExist = Address::where('city', $supplierAddressViewModel->getCity())
            ->where('email', $supplierAddressViewModel->getEmail())
            ->where('country', $supplierAddressViewModel->getCountry())
            ->where('zipCode', $supplierAddressViewModel->getZipCode())
            ->where('firstMobileNo', $supplierAddressViewModel->getFirstMobileNo())
            ->where('secondMobileNo', $supplierAddressViewModel->getSecondMobileNo())
            ->where('linkUpId', $supplierAddressViewModel->getSupplierId())
            ->where('addressType', AddressType::SUPPLIER->value)
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

    /**
     * @return array
     */
    public function read(): array
    {
        return [];
    }
}
