<?php

namespace App\UseCases;

use App\Enums\CustomResponseCode;
use App\Enums\CustomResponseMsg;
use App\Models\CustomResponse;
use App\Repositories\BillRepository;
use App\Repositories\ProductRepository;
use App\Repositories\UserInfoRepository;
use App\ViewModels\BillViewModel;
use App\ViewModels\ProductViewModel;
use App\ViewModels\SaleViewModel;

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

        $products = $this->productRepository->getProductsDetailsByCodes($productCodes);

        foreach ($products as $pKey=>$pVal){
            $salesViewModels[$pKey]["vatPercentage"] = $pVal["vatPercentage"];
            $salesViewModels[$pKey]["singlePrice"] = $pVal["singlePurchasePrice"];
        }

        $res->setSaleViewModels($salesViewModels);
        $res->setCode(CustomResponseCode::SUCCESS->value);
        $res->setMsg(CustomResponseMsg::SUCCESS->value);

        return $res;
    }
}
