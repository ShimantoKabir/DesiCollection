<?php

namespace App\ViewModels;

use App\Enums\CustomResponseCode;
use App\Enums\CustomResponseMsg;
use App\Enums\OperationType;
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
    public ?int $billNumber;
    public int $totalQuantity;
    public int $availableQuantity;
    public int $maxOfferPercentage;
    public int $maxProfitPercentage;
    public int $singlePurchasePrice;
    public array $imageIds;
    public ?string $ip;
    public ?string $createdAt;
    public ?string $updatedAt;
    public ?int $modifiedBy;
    public ?string $startDate;
    public ?string $endDate;
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
     * @return int|null
     */
    public function getBillNumber(): ?int
    {
        return $this->billNumber;
    }

    /**
     * @param int|null $billNumber
     */
    public function setBillNumber(?int $billNumber): void
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
    public function getMaxOfferPercentage(): int
    {
        return $this->maxOfferPercentage;
    }

    /**
     * @return int
     */
    public function getMaxProfitPercentage(): int
    {
        return $this->maxProfitPercentage;
    }

    /**
     * @param int $maxOfferPercentage
     */
    public function setMaxOfferPercentage(int $maxOfferPercentage): void
    {
        $this->maxOfferPercentage = $maxOfferPercentage;
    }

    /**
     * @param int $maxProfitPercentage
     */
    public function setMaxProfitPercentage(int $maxProfitPercentage): void
    {
        $this->maxProfitPercentage = $maxProfitPercentage;
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
     * @return array
     */
    public function getImages(): array
    {
        return $this->images;
    }

    /**
     * @param array $images
     */
    public function setImages(array $images): void
    {
        $this->images = $images;
    }

    /**
     * @return string|null
     */
    public function getIp(): ?string
    {
        return $this->ip;
    }

    /**
     * @param string|null $ip
     */
    public function setIp(?string $ip): void
    {
        $this->ip = $ip;
    }

    /**
     * @return string|null
     */
    public function getCreatedAt(): ?string
    {
        return $this->createdAt;
    }

    /**
     * @param string|null $createdAt
     */
    public function setCreatedAt(?string $createdAt): void
    {
        $this->createdAt = $createdAt;
    }

    /**
     * @return string|null
     */
    public function getUpdatedAt(): ?string
    {
        return $this->updatedAt;
    }

    /**
     * @param string|null $updatedAt
     */
    public function setUpdatedAt(?string $updatedAt): void
    {
        $this->updatedAt = $updatedAt;
    }

    /**
     * @return int|null
     */
    public function getModifiedBy(): ?int
    {
        return $this->modifiedBy;
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

    public function __construct(ProductUseCase $productUseCase)
    {
        $this->productUseCase = $productUseCase;
    }


    public function getIndexData(Request $request) : CustomResponse
    {
        $authResponse = $this->checkAuthValidation($request,OperationType::READ);

        if($authResponse != CustomResponseMsg::OK->value){
            return (new CustomResponse())->setResponse(CustomResponseCode::ERROR->value, $authResponse);
        }

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

//        $x = new CustomResponse();
//        $x->setCode(5);
//        $x->setMsg("ok");

        return $this->productUseCase->getIndexData($this);
    }

}
