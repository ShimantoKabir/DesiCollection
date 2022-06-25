<?php

namespace App\ViewModels;

use App\Enums\CustomResponseCode;
use App\Enums\CustomResponseMsg;
use App\Models\CustomResponse;
use App\UseCases\ProductUseCase;
use Illuminate\Http\Request;

class ProductViewModel extends BaseViewModel
{
    public ?string $code;
    public ?int $typeId;
    public ?string $typeName;
    public ?int $sizeId;
    public ?string $sizeName;
    public ?int $colorId;
    public ?string $colorName;
    public ?int $brandId;
    public ?string $brandName;
    public ?int $fabricId;
    public ?string $fabricName;
    public ?int $userTypeId;
    public ?string $userTypeName;
    public ?int $userAgeId;
    public ?string $billNumber;
    public int $totalQuantity;
    public int $availableQuantity;
    public int $minOfferPercentage;
    public int $minProfitPercentage;
    public int $singlePurchasePrice;
    public ?string $startDate;
    public ?string $endDate;
    public ?array $images;
    public ?array $deletedImageIds;
    private ProductUseCase $productUseCase;

    /**
     * @return string|null
     */
    public function getCode(): ?string
    {
        return $this->code;
    }

    /**
     * @param string|null $code
     */
    public function setCode(?string $code): void
    {
        $this->code = $code;
    }

    /**
     * @return int|null
     */
    public function getTypeId(): ?int
    {
        return $this->typeId;
    }

    /**
     * @param int|null $typeId
     */
    public function setTypeId(?int $typeId): void
    {
        $this->typeId = $typeId;
    }

    /**
     * @return string|null
     */
    public function getTypeName(): ?string
    {
        return $this->typeName;
    }

    /**
     * @param string|null $typeName
     */
    public function setTypeName(?string $typeName): void
    {
        $this->typeName = $typeName;
    }

    /**
     * @return int|null
     */
    public function getSizeId(): ?int
    {
        return $this->sizeId;
    }

    /**
     * @param int|null $sizeId
     */
    public function setSizeId(?int $sizeId): void
    {
        $this->sizeId = $sizeId;
    }

    /**
     * @return string|null
     */
    public function getSizeName(): ?string
    {
        return $this->sizeName;
    }

    /**
     * @param string|null $sizeName
     */
    public function setSizeName(?string $sizeName): void
    {
        $this->sizeName = $sizeName;
    }

    /**
     * @return int|null
     */
    public function getColorId(): ?int
    {
        return $this->colorId;
    }

    /**
     * @return string|null
     */
    public function getColorName(): ?string
    {
        return $this->colorName;
    }

    /**
     * @param int|null $colorId
     */
    public function setColorId(?int $colorId): void
    {
        $this->colorId = $colorId;
    }

    /**
     * @param string|null $colorName
     */
    public function setColorName(?string $colorName): void
    {
        $this->colorName = $colorName;
    }

    /**
     * @return int|null
     */
    public function getBrandId(): ?int
    {
        return $this->brandId;
    }

    /**
     * @return string|null
     */
    public function getBrandName(): ?string
    {
        return $this->brandName;
    }

    /**
     * @param int|null $brandId
     */
    public function setBrandId(?int $brandId): void
    {
        $this->brandId = $brandId;
    }

    /**
     * @param string|null $brandName
     */
    public function setBrandName(?string $brandName): void
    {
        $this->brandName = $brandName;
    }

    /**
     * @return int|null
     */
    public function getFabricId(): ?int
    {
        return $this->fabricId;
    }

    /**
     * @return string|null
     */
    public function getFabricName(): ?string
    {
        return $this->fabricName;
    }

    /**
     * @param int|null $fabricId
     */
    public function setFabricId(?int $fabricId): void
    {
        $this->fabricId = $fabricId;
    }

    /**
     * @param string|null $fabricName
     */
    public function setFabricName(?string $fabricName): void
    {
        $this->fabricName = $fabricName;
    }

    /**
     * @return int|null
     */
    public function getUserAgeId(): ?int
    {
        return $this->userAgeId;
    }

    /**
     * @param int|null $userTypeId
     */
    public function setUserTypeId(?int $userTypeId): void
    {
        $this->userTypeId = $userTypeId;
    }

    /**
     * @return int|null
     */
    public function getUserTypeId(): ?int
    {
        return $this->userTypeId;
    }

    /**
     * @return string|null
     */
    public function getUserTypeName(): ?string
    {
        return $this->userTypeName;
    }

    /**
     * @param string|null $userTypeName
     */
    public function setUserTypeName(?string $userTypeName): void
    {
        $this->userTypeName = $userTypeName;
    }

    /**
     * @param int|null $userAgeId
     */
    public function setUserAgeId(?int $userAgeId): void
    {
        $this->userAgeId = $userAgeId;
    }

    /**
     * @return string|null
     */
    public function getBillNumber(): ?string
    {
        return $this->billNumber;
    }

    /**
     * @param string|null $billNumber
     */
    public function setBillNumber(?string $billNumber): void
    {
        $this->billNumber = $billNumber;
    }

    /**
     * @return int
     */
    public function getTotalQuantity(): int
    {
        return $this->totalQuantity;
    }

    /**
     * @param int $totalQuantity
     */
    public function setTotalQuantity(int $totalQuantity): void
    {
        $this->totalQuantity = $totalQuantity;
    }

    /**
     * @return int
     */
    public function getAvailableQuantity(): int
    {
        return $this->availableQuantity;
    }

    /**
     * @param int $availableQuantity
     */
    public function setAvailableQuantity(int $availableQuantity): void
    {
        $this->availableQuantity = $availableQuantity;
    }

    /**
     * @return int
     */
    public function getSinglePurchasePrice(): int
    {
        return $this->singlePurchasePrice;
    }

    /**
     * @param int $singlePurchasePrice
     */
    public function setSinglePurchasePrice(int $singlePurchasePrice): void
    {
        $this->singlePurchasePrice = $singlePurchasePrice;
    }

    /**
     * @param array|null $images
     */
    public function setImages(?array $images): void
    {
        $this->images = $images;
    }

    /**
     * @return array|null
     */
    public function getImages(): ?array
    {
        return $this->images;
    }

    /**
     * @param int|null $modifiedBy
     */
    public function setModifiedBy(?int $modifiedBy): void
    {
        $this->modifiedBy = $modifiedBy;
    }

    /**
     * @param string|null $startDate
     */
    public function setStartDate(?string $startDate): void
    {
        $this->startDate = $startDate;
    }

    /**
     * @return string|null
     */
    public function getStartDate(): ?string
    {
        return $this->startDate;
    }

    /**
     * @param string|null $endDate
     */
    public function setEndDate(?string $endDate): void
    {
        $this->endDate = $endDate;
    }

    /**
     * @return string|null
     */
    public function getEndDate(): ?string
    {
        return $this->endDate;
    }

    /**
     * @return int
     */
    public function getMinOfferPercentage(): int
    {
        return $this->minOfferPercentage;
    }

    /**
     * @return int
     */
    public function getMinProfitPercentage(): int
    {
        return $this->minProfitPercentage;
    }

    /**
     * @param int $minOfferPercentage
     */
    public function setMinOfferPercentage(int $minOfferPercentage): void
    {
        $this->minOfferPercentage = $minOfferPercentage;
    }

    /**
     * @param int $minProfitPercentage
     */
    public function setMinProfitPercentage(int $minProfitPercentage): void
    {
        $this->minProfitPercentage = $minProfitPercentage;
    }

    /**
     * @return array|null
     */
    public function getDeletedImageIds(): ?array
    {
        return $this->deletedImageIds;
    }

    /**
     * @param array|null $deletedImageIds
     */
    public function setDeletedImageIds(?array $deletedImageIds): void
    {
        $this->deletedImageIds = $deletedImageIds;
    }

    public function __construct(ProductUseCase $productUseCase)
    {
        $this->productUseCase = $productUseCase;
    }

    public function getIndexData(Request $request) : CustomResponse
    {
        $this->setTypeId($request->productViewModel["typeId"]);
        $this->setSizeId($request->productViewModel["sizeId"]);
        $this->setColorId($request->productViewModel["colorId"]);
        $this->setBrandId($request->productViewModel["brandId"]);
        $this->setFabricId($request->productViewModel["fabricId"]);
        $this->setUserAgeId($request->productViewModel["userAgeId"]);
        $this->setUserTypeId($request->productViewModel["userTypeId"]);
        $this->setBillNumber($request->productViewModel["billNumber"]);
        $this->setStartDate($request->productViewModel["startDate"]);
        $this->setEndDate($request->productViewModel["endDate"]);
        $this->setModifiedBy($request->modifiedBy);
        return $this->productUseCase->getIndexData($this);
    }

    public function save(Request $request) : CustomResponse
    {

        $productViewModel = json_decode($request->productViewModel,true);

        $inputValidationResponse = $this->checkInputValidation($productViewModel,[
            'billNumber' => 'required|string',
            'totalQuantity' => 'required|int',
            'minOfferPercentage' => 'required|int',
            'minProfitPercentage' => 'required|int',
            'singlePurchasePrice' => 'required|int'
        ]);

        if($inputValidationResponse != CustomResponseMsg::OK->value){
            return (new CustomResponse())->setResponse(CustomResponseCode::ERROR->value, $inputValidationResponse);
        }

        if($request->hasFile('productImages')){
            $imageValidationResponse = $this->checkInputValidation($request->all(),[
                'productImages' => 'required',
                'productImages.*' => 'mimes:jpg,png|max:2048'
            ]);

            if($imageValidationResponse != CustomResponseMsg::OK->value){
                return (new CustomResponse())->setResponse(CustomResponseCode::ERROR->value, $imageValidationResponse);
            }
        }

        $this->setTypeId($productViewModel["typeId"]);
        $this->setSizeId($productViewModel["sizeId"]);
        $this->setColorId($productViewModel["colorId"]);
        $this->setBrandId($productViewModel["brandId"]);
        $this->setFabricId($productViewModel["fabricId"]);
        $this->setUserAgeId($productViewModel["userAgeId"]);
        $this->setUserTypeId($productViewModel["userTypeId"]);
        $this->setBillNumber($productViewModel["billNumber"]);
        $this->setTotalQuantity($productViewModel["totalQuantity"]);
        $this->setSinglePurchasePrice($productViewModel["singlePurchasePrice"]);
        $this->setMinOfferPercentage($productViewModel["minOfferPercentage"]);
        $this->setMinProfitPercentage($productViewModel["minProfitPercentage"]);
        $this->setIp($request->ip());
        $this->setModifiedBy($request->modifiedBy);
        $file = $request->hasFile('productImages') ? $request->file("productImages") : null;
        $this->setImages($file);
        return $this->productUseCase->save($this);
    }

    public function update(Request $request) : CustomResponse
    {
        $productViewModel = json_decode($request->productViewModel,true);

        $inputValidationResponse = $this->checkInputValidation($productViewModel,[
            'billNumber' => 'required|string',
            'totalQuantity' => 'required|int',
            'minOfferPercentage' => 'required|int',
            'minProfitPercentage' => 'required|int',
            'singlePurchasePrice' => 'required|int'
        ]);

        if($inputValidationResponse != CustomResponseMsg::OK->value){
            return (new CustomResponse())->setResponse(CustomResponseCode::ERROR->value, $inputValidationResponse);
        }

        if($request->hasFile('productImages')){
            $imageValidationResponse = $this->checkInputValidation($request->all(),[
                'productImages' => 'required',
                'productImages.*' => 'mimes:jpg,png|max:2048'
            ]);

            if($imageValidationResponse != CustomResponseMsg::OK->value){
                return (new CustomResponse())->setResponse(CustomResponseCode::ERROR->value, $imageValidationResponse);
            }
        }

        $this->setId($productViewModel["id"]);
        $this->setTypeId($productViewModel["typeId"]);
        $this->setSizeId($productViewModel["sizeId"]);
        $this->setColorId($productViewModel["colorId"]);
        $this->setBrandId($productViewModel["brandId"]);
        $this->setFabricId($productViewModel["fabricId"]);
        $this->setUserAgeId($productViewModel["userAgeId"]);
        $this->setUserTypeId($productViewModel["userTypeId"]);
        $this->setBillNumber($productViewModel["billNumber"]);
        $this->setTotalQuantity($productViewModel["totalQuantity"]);
        $this->setAvailableQuantity($productViewModel["availableQuantity"]);
        $this->setSinglePurchasePrice($productViewModel["singlePurchasePrice"]);
        $this->setMinOfferPercentage($productViewModel["minOfferPercentage"]);
        $this->setMinProfitPercentage($productViewModel["minProfitPercentage"]);
        $this->setDeletedImageIds($productViewModel["deletedImageIds"]);
        $this->setIp($request->ip());
        $this->setModifiedBy($request->modifiedBy);
        $file = $request->hasFile('productImages') ? $request->file("productImages") : null;
        $this->setImages($file);

        return $this->productUseCase->update($this);
    }

    public function remove(Request $request) : CustomResponse
    {

        $inputValidationResponse = $this->checkInputValidation($request->productViewModel,[
            'id' => 'required|int'
        ]);

        if($inputValidationResponse != CustomResponseMsg::OK->value){
            return (new CustomResponse())->setResponse(CustomResponseCode::ERROR->value, $inputValidationResponse);
        }

        $this->setId($request->productViewModel["id"]);
        return $this->productUseCase->remove($this);

    }

}
