<?php

namespace App\UseCases;

use App\Models\CustomResponse;
use App\Repositories\AgeRepository;
use App\Repositories\BrandRepository;
use App\Repositories\ColorRepository;
use App\Repositories\FabricRepository;
use App\Repositories\ProductRepository;
use App\Repositories\ProductUserTypeRepository;
use App\Repositories\SizeRepository;
use App\Repositories\SupplierBillRepository;
use App\Repositories\TypeRepository;
use App\ViewModels\ProductViewModel;

class ProductUseCase extends BaseUseCase
{

    private ProductRepository $productRepository;
    private FabricRepository $fabricRepository;
    private SizeRepository $sizeRepository;
    private ColorRepository $colorRepository;
    private BrandRepository $brandRepository;
    private TypeRepository $typeRepository;
    private AgeRepository $ageRepository;
    private ProductUserTypeRepository $productUserTypeRepository;
    private SupplierBillRepository $supplierBillRepository;

    public function __construct(
        ProductRepository $productRepository,
        FabricRepository $fabricRepository,
        SizeRepository $sizeRepository,
        ColorRepository $colorRepository,
        BrandRepository $brandRepository,
        TypeRepository $typeRepository,
        AgeRepository $ageRepository,
        ProductUserTypeRepository $productUserTypeRepository,
        SupplierBillRepository $supplierBillRepository
    )
    {
        $this->productRepository = $productRepository;
        $this->fabricRepository = $fabricRepository;
        $this->sizeRepository = $sizeRepository;
        $this->colorRepository = $colorRepository;
        $this->brandRepository = $brandRepository;
        $this->typeRepository = $typeRepository;
        $this->ageRepository = $ageRepository;
        $this->productUserTypeRepository = $productUserTypeRepository;
        $this->supplierBillRepository = $supplierBillRepository;
    }

    public function getIndexData(ProductViewModel $productViewModel) : CustomResponse
    {
        $indexData = $this->productRepository->getIndexData($productViewModel);
        $indexData->setFabrics($this->fabricRepository->read());
        $indexData->setSizes($this->sizeRepository->read());
        $indexData->setColors($this->colorRepository->read());
        $indexData->setBrands($this->brandRepository->read());
        $indexData->setTypes($this->typeRepository->read());
        $indexData->setAges($this->ageRepository->read());
        $indexData->setUserTypes($this->productUserTypeRepository->read());
        $indexData->setSupplierBills($this->supplierBillRepository->read());

        return $indexData;
    }

}
