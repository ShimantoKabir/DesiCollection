<?php

namespace App\UseCases;

use App\Enums\CustomResponseCode;
use App\Enums\ImageType;
use App\Models\AppImageViewModel;
use App\Models\CustomResponse;
use App\Repositories\AgeRepository;
use App\Repositories\AppImageRepository;
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
    private AppImageRepository $appImageRepository;

    public function __construct(
        ProductRepository $productRepository,
        FabricRepository $fabricRepository,
        SizeRepository $sizeRepository,
        ColorRepository $colorRepository,
        BrandRepository $brandRepository,
        TypeRepository $typeRepository,
        AgeRepository $ageRepository,
        ProductUserTypeRepository $productUserTypeRepository,
        SupplierBillRepository $supplierBillRepository,
        AppImageRepository $appImageRepository
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
        $this->appImageRepository = $appImageRepository;
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

        $products = $indexData->getProducts();

        foreach ($products as $product){
            $product->images = $this->appImageRepository->readByReferenceId($product->id);
        }

        return $indexData;
    }

    public function save(ProductViewModel $productViewModel) : CustomResponse
    {
        $images = [];
        $res = $this->productRepository->create($productViewModel);

        if ($res->getCode() == CustomResponseCode::SUCCESS->value){
            if (!is_null($productViewModel->getImages())) {
                foreach ($productViewModel->getImages() as $file) {
                    $imageName = $this->productRepository->uploadFileToFtp($file);
                    if(!is_null($imageName)){
                        $appImageViewModel = new AppImageViewModel();
                        $appImageViewModel->setImageName($imageName);
                        $appImageViewModel->setIsActive(0);
                        $appImageViewModel->setImageType(ImageType::PRODUCT->value);
                        $appImageViewModel->setReferenceId($res->getModel()["id"]);
                        $appImageViewModel->setIp($productViewModel->getIp());
                        $appImageViewModel->setModifiedBy($productViewModel->getModifiedBy());
                        $imgUploadEntryRes = $this->appImageRepository->create($appImageViewModel);
                        if($imgUploadEntryRes->getCode() == CustomResponseCode::SUCCESS->value){
                            $images[] = $imgUploadEntryRes->getModel();
                        }
                    }
                }
            }
        }

        $res->setImages($images);

        return $res;
    }

    public function update(ProductViewModel $productViewModel) : CustomResponse
    {
        $res = $this->productRepository->update($productViewModel);

        if (count($productViewModel->getDeletedImageIds()) > 0){
            $appImages = $this->appImageRepository->readyByIds($productViewModel->getDeletedImageIds());
            $this->appImageRepository->deleteByIds($productViewModel->getDeletedImageIds());

            foreach ($appImages as $appImage){
                $this->productRepository->deleteFileFromFtp($appImage["imageName"]);
            }
        }

        if ($res->getCode() == CustomResponseCode::SUCCESS->value && !is_null($productViewModel->getImages())){
            foreach ($productViewModel->getImages() as $file) {
                $imageName = $this->productRepository->uploadFileToFtp($file);
                if(!is_null($imageName)){
                    $appImageViewModel = new AppImageViewModel();
                    $appImageViewModel->setImageName($imageName);
                    $appImageViewModel->setIsActive(0);
                    $appImageViewModel->setImageType(ImageType::PRODUCT->value);
                    $appImageViewModel->setReferenceId($productViewModel->getId());
                    $appImageViewModel->setIp($productViewModel->getIp());
                    $appImageViewModel->setModifiedBy($productViewModel->getModifiedBy());
                    $this->appImageRepository->create($appImageViewModel);
                }
            }
        }

        $res->setImages($this->appImageRepository->readByReferenceId($productViewModel->getId()));

        return $res;
    }

    public function remove(ProductViewModel $productViewModel) : CustomResponse
    {
        $res = $this->productRepository->delete($productViewModel);

        $images = $this->appImageRepository->readByReferenceId($productViewModel->getId());

        if (count($images)>0){
            $this->appImageRepository->deleteByReferenceId($productViewModel->getId());
            foreach ($images as $image){
                $this->productRepository->deleteFileFromFtp($image["imageName"]);
            }
        }

        return  $res;
    }


}
