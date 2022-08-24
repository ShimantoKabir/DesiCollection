<?php

namespace App\UseCases;

use App\Enums\CustomResponseCode;
use App\Enums\CustomResponseMsg;
use App\Models\CustomResponse;
use App\Repositories\BillRepository;
use App\Repositories\ProductRepository;
use App\Repositories\UserInfoRepository;
use App\ViewModels\BillViewModel;

class BillUseCase extends BaseUseCase
{

    private UserInfoRepository $userInfoRepository;
    private BillRepository $billRepository;
    private ProductRepository $productRepository;

    public function __construct(
        UserInfoRepository $userInfoRepository,
        BillRepository $billRepository,
        ProductRepository $productRepository
    )
    {
        $this->userInfoRepository = $userInfoRepository;
        $this->billRepository = $billRepository;
        $this->productRepository = $productRepository;
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

        $this->billRepository->create($billViewModel);

        return $res;
    }
}
