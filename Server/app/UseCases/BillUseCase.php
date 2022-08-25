<?php

namespace App\UseCases;

use App\Enums\CustomResponseCode;
use App\Enums\CustomResponseMsg;
use App\Models\CustomRequest;
use App\Models\CustomResponse;
use App\Repositories\BillRepository;
use App\Repositories\ProductRepository;
use App\Repositories\SaleRepository;
use App\Repositories\UserInfoRepository;
use App\ViewModels\BillViewModel;
use App\ViewModels\UserInfoViewModel;

class BillUseCase extends BaseUseCase
{

    private UserInfoRepository $userInfoRepository;
    private BillRepository $billRepository;
    private ProductRepository $productRepository;
    private SaleRepository $saleRepository;

    public function __construct(
        UserInfoRepository $userInfoRepository,
        BillRepository $billRepository,
        ProductRepository $productRepository,
        SaleRepository $saleRepository
    )
    {
        $this->userInfoRepository = $userInfoRepository;
        $this->billRepository = $billRepository;
        $this->productRepository = $productRepository;
        $this->saleRepository = $saleRepository;
    }

    public function getIndexData(BillViewModel $billViewModel) : CustomResponse
    {
        $response = new CustomResponse();
        $response->setCode(CustomResponseCode::SUCCESS->value);
        $response->setMsg(CustomResponseMsg::OK->value);
        return $response;
    }

    public function getCalculationDetails(BillViewModel $billViewModel) : CustomResponse
    {
        $res = new CustomResponse();
        $salesViewModels = $billViewModel->getSaleViewModels();
        $productCodes = [];
        foreach ($salesViewModels as $item) {
            $productCodes[] = $item["productCode"];
        }

        $isExists = $this->productRepository->isProductCodesExist($productCodes);

        if (!$isExists){
            $res->setCode(CustomResponseCode::ERROR->value);
            $res->setMsg("Product code not found!");
            return $res;
        }

        $products = $this->productRepository->getProductsDetailsByCodes($productCodes);

        $grandTotal = 0;

        foreach ($products as $pKey=>$pVal){
            $salesViewModels[$pKey]["vatPercentage"] = $pVal["vatPercentage"];
            $salesViewModels[$pKey]["singlePrice"] = $pVal["singlePurchasePrice"];

            $priceWithVat = $pVal["singlePurchasePrice"] * ($pVal["vatPercentage"]/100);

            $totalVat = $salesViewModels[$pKey]["productQuantity"] * round($priceWithVat);
            $totalPrice = $salesViewModels[$pKey]["productQuantity"] * $pVal["singlePurchasePrice"];

            $salesViewModels[$pKey]["total"] =  $totalVat + $totalPrice;

            $grandTotal = $grandTotal + $salesViewModels[$pKey]["total"];
        }

        $res->setGrandTotal($grandTotal);
        $res->setSaleViewModels($salesViewModels);
        $res->setCode(CustomResponseCode::SUCCESS->value);
        $res->setMsg(CustomResponseMsg::SUCCESS->value);

        return $res;
    }

    public function save(BillViewModel $billViewModel) : CustomResponse
    {
        $res = new CustomResponse();
        $res->setCode(CustomResponseCode::SUCCESS->value);
        $res->setMsg("Offline entry save successfully!");

        $salesViewModels = $billViewModel->getSaleViewModels();

        $productCodes = [];
        $productCodeWithQty = [];

        foreach ($salesViewModels as $item) {
            $productCodes[] = $item["productCode"];
            $productCodeWithQty[] = [
                "code" => $item["productCode"],
                "quantity" => $item["productQuantity"]
            ];
        }

        $isExists = $this->productRepository->isProductCodesExist($productCodes);

        if (!$isExists){
            $res->setCode(CustomResponseCode::ERROR->value);
            $res->setMsg(CustomResponseMsg::PRODUCT_NOT_FOUND->value);
            return $res;
        }

        $product = $this->productRepository->checkProductQty($productCodeWithQty);

        if (!is_null($product)){
            $res->setCode(CustomResponseCode::ERROR->value);
            $res->setMsg("Product code: ".$product->code." is not have enough quantity to sell");
            return $res;
        }

        $customer = $this->userInfoRepository->getCustomerDetailsByMobileNumber($billViewModel->getMobileNumber());

        $customerSaveRes = null;
        if (is_null($customer)){
            $request = new CustomRequest();
            $request->setFirstName($billViewModel->getFirstName());
            $request->setMobileNumber($billViewModel->getMobileNumber());
            $customerSaveRes = $this->userInfoRepository->saveCustomer($request);
        }

        if(is_null($customerSaveRes) || $customerSaveRes->getCode() == CustomResponseCode::SUCCESS->value){
            $res->setCode(CustomResponseCode::ERROR->value);
            $res->setMsg("No customer found or couldn't create a new customer!");
            return $res;
        }

        $billViewModel->setCustomerId($customer->id);
        $billSaveRes = $this->billRepository->create($billViewModel);

        if($billSaveRes->getCode() == CustomResponseCode::ERROR->value){
            $res->setCode(CustomResponseCode::ERROR->value);
            $res->setMsg("Couldn't save the bill!");
            return $res;
        }

        $billModel = $billSaveRes->getModel();
        foreach ($salesViewModels as $item) {
            $item["billNumber"] = $billModel->billNumber;
            $item["ip"] = $billViewModel->getId();
            $item["modifiedBy"] = $billViewModel->getModifiedBy();
        }

        $salesSaveRes = $this->saleRepository->createMultiple($salesViewModels);

        if ($salesSaveRes->getCode() == CustomResponseCode::ERROR->value){
            $res->setMsg(CustomResponseMsg::ERROR->value);
            $res->setMsg("Couldn't save the sales!");
        }

        return $res;
    }
}
