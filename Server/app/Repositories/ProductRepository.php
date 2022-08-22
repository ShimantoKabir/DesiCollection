<?php

namespace App\Repositories;

use App\Enums\CustomResponseCode;
use App\Enums\CustomResponseMsg;
use App\Models\CustomResponse;
use App\Models\Product;
use App\Repositories\Interfaces\IProductRepository;
use App\ViewModels\ProductViewModel;
use Illuminate\Database\Eloquent\Model;
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
        $date = $this->getCurrentDate();
        $res = new CustomResponse();
        DB::beginTransaction();
        try{

            $model = new Product();
            $model->code = "SKU".time();
            $model->typeId = $productViewModel->getTypeId();
            $model->sizeId = $productViewModel->getSizeId();
            $model->colorId = $productViewModel->getColorId();
            $model->brandId = $productViewModel->getBrandId();
            $model->fabricId = $productViewModel->getFabricId();
            $model->userAgeId = $productViewModel->getUserAgeId();
            $model->userTypeId = $productViewModel->getUserTypeId();
            $model->billNumber = $productViewModel->getBillNumber();
            $model->totalQuantity = $productViewModel->getTotalQuantity();
            $model->vatPercentage = $productViewModel->getVatPercentage();
            $model->availableQuantity = $productViewModel->getTotalQuantity();
            $model->minOfferPercentage = $productViewModel->getMinOfferPercentage();
            $model->minProfitPercentage = $productViewModel->getMinProfitPercentage();
            $model->singlePurchasePrice = $productViewModel->getSinglePurchasePrice();
            $model->ip = $productViewModel->getIp();
            $model->createdAt = $date;
            $model->modifiedBy = $productViewModel->getModifiedBy();
            $model->save();

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

    public function update(ProductViewModel $productViewModel): CustomResponse
    {
        $date = $this->getCurrentDate();
        $res = new CustomResponse();
        DB::beginTransaction();
        try{

            Product::where('id',$productViewModel->getId())
            ->update([
                'typeId' => $productViewModel->getTypeId(),
                'sizeId' => $productViewModel->getSizeId(),
                'colorId' => $productViewModel->getColorId(),
                'brandId' => $productViewModel->getBrandId(),
                'fabricId' => $productViewModel->getFabricId(),
                'userAgeId' => $productViewModel->getUserAgeId(),
                'userTypeId' => $productViewModel->getUserTypeId(),
                'billNumber' => $productViewModel->getBillNumber(),
                'totalQuantity' => $productViewModel->getTotalQuantity(),
                'vatPercentage' => $productViewModel->getVatPercentage(),
                'minOfferPercentage' => $productViewModel->getMinOfferPercentage(),
                'minProfitPercentage' => $productViewModel->getMinProfitPercentage(),
                'singlePurchasePrice' => $productViewModel->getSinglePurchasePrice(),
                'ip' => $productViewModel->getIp(),
                'updatedAt' => $date,
                'modifiedBy' => $productViewModel->getModifiedBy()
            ]);

            DB::commit();
            $res->setCode(CustomResponseCode::SUCCESS->value);
            $res->setMsg(CustomResponseMsg::SUCCESS->value);
            $res->setModel($productViewModel);

        }catch (\Exception $e){
            DB::rollBack();
            $res->setCode(CustomResponseCode::ERROR->value);
            $res->setMsg($e->getMessage());
        }

        return $res;
    }

    public function delete(ProductViewModel $productViewModel): CustomResponse
    {
        $res = new CustomResponse();
        DB::beginTransaction();
        try{

            Product::where('id',$productViewModel->getId())->delete();

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

        return $productQuery->get()->toArray();
    }

    /**
     * @param array $codes
     * @return array
     */
    public function getProductsDetailsByCodes(array $codes): array
    {
        return Product::query()
        ->select("vatPercentage","singlePurchasePrice")
        ->whereIn("code",$codes)
        ->get()->toArray();
    }
}
