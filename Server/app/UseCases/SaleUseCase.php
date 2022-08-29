<?php

namespace App\UseCases;

use App\Models\CustomResponse;
use App\Models\Sale;
use App\Repositories\SaleRepository;
use App\ViewModels\SaleViewModel;

class SaleUseCase extends BaseUseCase
{
    private SaleRepository $saleRepository;

    public function __construct(SaleRepository $saleRepository)
    {
        $this->saleRepository = $saleRepository;
    }

    public function getSalesByBillNumber(SaleViewModel $saleViewModel) : CustomResponse
    {
        return $this->saleRepository->getSalesByBillNumber($saleViewModel);
    }


}
