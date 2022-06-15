<?php

namespace App\Repositories;

use App\Enums\AddressType;
use App\Enums\CustomResponseCode;
use App\Enums\CustomResponseMsg;
use App\Models\CustomResponse;
use App\Models\SupplierBill;
use App\Repositories\Interfaces\ISupplierBillRepository;
use App\ViewModels\SupplierBillViewModel;
use Illuminate\Support\Facades\DB;

class SupplierBillRepository extends BaseRepository implements ISupplierBillRepository
{
    public function read(): array
    {
        return DB::table('supplier_bills')
        ->join('suppliers', 'supplier_bills.supplierId', '=', 'suppliers.id')
        ->select(
            "supplier_bills.id",
            "supplier_bills.supplierId",
            "supplier_bills.billNumber",
            "supplier_bills.billingDate",
            "supplier_bills.debitAmount",
            "supplier_bills.creditAmount",
            "supplier_bills.totalQuantity",
            "supplier_bills.imageName",
            DB::raw($this->getImageRawSql("supplier_bills.imageName","imagePath")),
            'suppliers.supplierName'
        )
        ->get()
        ->toArray();
    }

    /**
     * @return CustomResponse
     */
    public function getIndexData(): CustomResponse
    {
        $res = new CustomResponse();
        $res->setCode(CustomResponseCode::SUCCESS->value);
        $res->setMsg(CustomResponseMsg::INIT_SUCCESS->value);
        $res->setSupplierBills($this->read());
        return $res;
    }


    /**
     * @param SupplierBillViewModel $supplierBillViewModel
     * @return CustomResponse
     */
    public function create(SupplierBillViewModel $supplierBillViewModel): CustomResponse
    {
        $date = $this->getCurrentDate();
        $res = new CustomResponse();
        DB::beginTransaction();
        try{

            $model = new SupplierBill();
            $model->supplierId = $supplierBillViewModel->getSupplierId();
            $model->billNumber = $supplierBillViewModel->getBillNumber();
            $model->billingDate = $supplierBillViewModel->getBillingDate();
            $model->debitAmount = $supplierBillViewModel->getDebitAmount();
            $model->totalQuantity = $supplierBillViewModel->getTotalQuantity();
            $model->imageName = $supplierBillViewModel->getImageName();
            $model->ip = $supplierBillViewModel->getIp();
            $model->modifiedBy = $supplierBillViewModel->getModifiedBy();
            $model->createdAt = $date;
            $model->save();

            $model->imagePath = $this->getAssetPrefix().$supplierBillViewModel->getImageName();

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
     * @param SupplierBillViewModel $supplierBillViewModel
     * @return CustomResponse
     */
    public function update(SupplierBillViewModel $supplierBillViewModel): CustomResponse
    {
        $date = $this->getCurrentDate();
        $res = new CustomResponse();
        DB::beginTransaction();
        try{

            SupplierBill::where('id',$supplierBillViewModel->getId())
            ->update([
                "supplierId" => $supplierBillViewModel->getSupplierId(),
                "billNumber" => $supplierBillViewModel->getBillNumber(),
                "billingDate" => $supplierBillViewModel->getBillingDate(),
                "debitAmount" => $supplierBillViewModel->getDebitAmount(),
                "totalQuantity" => $supplierBillViewModel->getTotalQuantity(),
                'imageName' => $supplierBillViewModel->getImageName(),
                "ip" => $supplierBillViewModel->getIp(),
                "updatedAt" => $date,
                "modifiedBy" => $supplierBillViewModel->getModifiedBy()
            ]);

            $supplierBillViewModel->setImagePath($this->getAssetPrefix().$supplierBillViewModel->getImageName());

            DB::commit();
            $res->setCode(CustomResponseCode::SUCCESS->value);
            $res->setMsg(CustomResponseMsg::SUCCESS->value);
            $res->setModel($supplierBillViewModel);

        }catch (\Exception $e){
            DB::rollBack();
            $res->setCode(CustomResponseCode::ERROR->value);
            $res->setMsg($e->getMessage());
        }

        return $res;
    }

    /**
     * @param SupplierBillViewModel $supplierBillViewModel
     * @return CustomResponse
     */
    public function delete(SupplierBillViewModel $supplierBillViewModel): CustomResponse
    {
        $res = new CustomResponse();
        DB::beginTransaction();
        try{

            SupplierBill::where('id',$supplierBillViewModel->getId())->delete();
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
     * @param SupplierBillViewModel $supplierBillViewModel
     * @return CustomResponse
     */
    public function isSupplierBillExist(SupplierBillViewModel $supplierBillViewModel): CustomResponse
    {
        $res = new CustomResponse();
        $isExist = SupplierBill::where("supplierId", $supplierBillViewModel->getSupplierId())
            ->where("billNumber", $supplierBillViewModel->getBillNumber())
            ->where("billingDate", $supplierBillViewModel->getBillingDate())
            ->where("debitAmount", $supplierBillViewModel->getDebitAmount())
            ->where("totalQuantity", $supplierBillViewModel->getTotalQuantity())
            ->exists();

        if($isExist){
            $res->setCode(CustomResponseCode::ERROR->value);
            $res->setMsg(CustomResponseMsg::SUPPLIER_EXIST->value);
        }else{
            $res->setCode(CustomResponseCode::SUCCESS->value);
            $res->setMsg(CustomResponseMsg::SUCCESS->value);
        }

        return $res;
    }
}
