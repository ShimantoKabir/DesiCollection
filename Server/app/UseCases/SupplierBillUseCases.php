<?php

namespace App\UseCases;

use App\Enums\CustomResponseCode;
use App\Models\CustomResponse;
use App\Repositories\SupplierBillRepository;
use App\Repositories\SupplierRepository;
use App\ViewModels\SupplierBillViewModel;

class SupplierBillUseCases extends BaseUseCase
{

    public SupplierBillRepository $supplierBillRepository;
    public SupplierRepository $supplierRepository;

    public function __construct(SupplierBillRepository $supplierBillRepository,
                                SupplierRepository $supplierRepository)
    {
        $this->supplierBillRepository = $supplierBillRepository;
        $this->supplierRepository = $supplierRepository;
    }

    public function getIndexData(SupplierBillViewModel $supplierBillViewModel) : CustomResponse
    {
        $indexData =  $this->supplierBillRepository->getIndexData($supplierBillViewModel);
        $indexData->setSuppliers($this->supplierRepository->read());
        return $indexData;
    }

    public function save(SupplierBillViewModel $supplierBillViewModel) : CustomResponse
    {
        $existResponse = $this->supplierBillRepository->isSupplierBillExist($supplierBillViewModel);

        if($existResponse->code == CustomResponseCode::ERROR->value){
            return $existResponse;
        }else{
            if (!is_null($supplierBillViewModel->getBillImage())){
                $billImageName = $this->supplierBillRepository->uploadFileToFtp($supplierBillViewModel->getBillImage());
                $supplierBillViewModel->setImageName($billImageName);
            }
            return $this->supplierBillRepository->create($supplierBillViewModel);
        }
    }

    public function update(SupplierBillViewModel $supplierBillViewModel) : CustomResponse
    {

        if (!is_null($supplierBillViewModel->getImageName()) &&
            $this->supplierBillRepository->IsFileExistInFtp($supplierBillViewModel->getImageName())){
            $isDeleted = $this->supplierBillRepository->deleteFileFromFtp($supplierBillViewModel->getImageName());
            if ($isDeleted){
                $supplierBillViewModel->setImageName(null);
            }
        }

        if (!is_null($supplierBillViewModel->getBillImage())){
            $billImageName = $this->supplierBillRepository->uploadFileToFtp($supplierBillViewModel->getBrandImage());
            $supplierBillViewModel->setImageName($billImageName);
        }

        return $this->supplierBillRepository->update($supplierBillViewModel);
    }

    public function remove(SupplierBillViewModel $supplierBillViewModel) : CustomResponse
    {
        if (!is_null($supplierBillViewModel->getImageName()) &&
            $this->supplierBillRepository->IsFileExistInFtp($supplierBillViewModel->getImageName())){
            $this->supplierBillRepository->deleteFileFromFtp($supplierBillViewModel->getImageName());
        }

        return $this->supplierBillRepository->delete($supplierBillViewModel);
    }

}
