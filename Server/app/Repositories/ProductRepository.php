<?php

namespace App\Repositories;

use App\Enums\CustomResponseCode;
use App\Enums\CustomResponseMsg;
use App\Models\CustomResponse;
use App\Repositories\Interfaces\IProductRepository;
use App\ViewModels\ProductViewModel;
use Illuminate\Support\Facades\DB;

class ProductRepository extends BaseRepository implements IProductRepository
{

    public function getIndexData(ProductViewModel $productViewModel): CustomResponse
    {
        $res = new CustomResponse();
        $res->setCode(CustomResponseCode::SUCCESS->value);
        $res->setMsg(CustomResponseMsg::INIT_SUCCESS->value);
        $res->setProducts($this->readProduct($productViewModel));
        return $res;
    }

    public function create(ProductViewModel $productViewModel): CustomResponse
    {
        // TODO: Implement create() method.
    }

    public function update(ProductViewModel $productViewModel): CustomResponse
    {
        // TODO: Implement update() method.
    }

    public function delete(ProductViewModel $productViewModel): CustomResponse
    {
        // TODO: Implement delete() method.
    }

    public function isProductExist(ProductViewModel $productViewModel): CustomResponse
    {
        // TODO: Implement isProductExist() method.
    }

    public function read(): array
    {
        return [];
    }

    public function readProduct(ProductViewModel $productViewModel): array
    {
        $productQuery = DB::table('products')
            ->join('sizes', 'sizes.id', '=', 'products.sizeId')
            ->join('colors', 'colors.id', '=', 'products.colorId')
            ->join('brands', 'brands.id', '=', 'products.brandId')
            ->join('fabrics', 'fabrics.id', '=', 'products.fabricId')
            ->join('product_types', 'product_types.id', '=', 'products.typeId')
            ->join('product_user_types', 'product_user_types.id', '=', 'products.userTypeId')
            ->join('product_user_ages', 'product_user_ages.id', '=', 'products.userAgeId')
            ->select(
                'products.*',
                'sizes.sizeName',
                'colors.colorName',
                'brands.brandName',
                'fabrics.fabricName',
                'product_types.typeName',
                'product_user_types.userTypeName',
                'product_user_ages.maxAge',
                'product_user_ages.minAge',
                'product_user_ages.fixedAge'
            );

        if (!is_null($productViewModel->getSizeId())){
            $productQuery->where("products.sizeId",'=',$productViewModel->getSizeId());
        }

        if (!is_null($productViewModel->getColorId())){
            $productQuery->where("products.colorId",'=',$productViewModel->getColorId());
        }

        if (!is_null($productViewModel->getBrandId())){
            $productQuery->where("products.brandId",'=',$productViewModel->getBrandId());
        }

        if (!is_null($productViewModel->getFabricId())){
            $productQuery->where("products.fabricId",'=',$productViewModel->getFabricId());
        }

        if (!is_null($productViewModel->getTypeId())){
            $productQuery->where("products.typeId",'=',$productViewModel->getTypeId());
        }

        if (!is_null($productViewModel->getUserAgeId())){
            $productQuery->where("products.userTypeId",'=',$productViewModel->getUserAgeId());
        }

        if (!is_null($productViewModel->getUserTypeId())){
            $productQuery->where("products.userAgeId",'=',$productViewModel->getUserTypeId());
        }

        if (!is_null($productViewModel->getStartDate())){
            $productQuery->where("products.userAgeId",'=',$productViewModel->getUserTypeId());
        }

        if (!is_null($productViewModel->getStartDate()) && !is_null($productViewModel->getEndDate())){
            $productQuery->whereBetween("createdAt",
                [
                    $productViewModel->getStartDate(),
                    $productViewModel->getEndDate()
                ]
            );
        }

        return $productQuery->get()->partition(15)->toArray();
    }
}
