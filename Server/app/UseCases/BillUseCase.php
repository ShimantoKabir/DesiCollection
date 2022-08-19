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
        $products = [];
        foreach ($billViewModel->getSaleViewModels() as $item) {
            $products[] = $this->productRepository->getProductDetailsByCode($item["productCode"]);
        }
        $res->setProducts($products);
        return $res;
    }
}
