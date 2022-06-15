<?php

namespace App\ViewModels;

use App\Enums\CustomResponseCode;
use App\Enums\CustomResponseMsg;
use App\Models\CustomResponse;
use App\UseCases\SupplierBillUseCases;
use Illuminate\Http\Request;

class SupplierBillViewModel extends BaseViewModel
{
    public int $supplierId;
    public string $billNumber;
    public string $billingDate;
    public int $debitAmount;
    public int $creditAmount;
    public int $totalQuantity;
    public $billImage;
    public ?string $imagePath;
    public ?string $imageName;
    public SupplierBillUseCases $supplierBillUseCases;

    public array $validationFields = [
        'supplierId' => 'required|int',
        'billNumber' => 'required|string',
        'billingDate' => 'required|string',
        'debitAmount' => 'required|int',
        'totalQuantity' => 'required|int'
    ];

    public function __construct(SupplierBillUseCases $supplierBillUseCases)
    {
        $this->supplierBillUseCases = $supplierBillUseCases;
    }

    /**
     * @param int $supplierId
     */
    public function setSupplierId(int $supplierId): void
    {
        $this->supplierId = $supplierId;
    }

    /**
     * @return int
     */
    public function getSupplierId(): int
    {
        return $this->supplierId;
    }

    /**
     * @return string
     */
    public function getBillNumber(): string
    {
        return $this->billNumber;
    }

    /**
     * @param string $billNumber
     */
    public function setBillNumber(string $billNumber): void
    {
        $this->billNumber = $billNumber;
    }

    /**
     * @return string
     */
    public function getBillingDate(): string
    {
        return $this->billingDate;
    }

    /**
     * @param string $billingDate
     */
    public function setBillingDate(string $billingDate): void
    {
        $this->billingDate = $billingDate;
    }

    /**
     * @return int
     */
    public function getDebitAmount(): int
    {
        return $this->debitAmount;
    }

    /**
     * @param int $debitAmount
     */
    public function setDebitAmount(int $debitAmount): void
    {
        $this->debitAmount = $debitAmount;
    }

    /**
     * @return int
     */
    public function getCreditAmount(): int
    {
        return $this->creditAmount;
    }

    /**
     * @param int $creditAmount
     */
    public function setCreditAmount(int $creditAmount): void
    {
        $this->creditAmount = $creditAmount;
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
    public function getTotalQuantity(): int
    {
        return $this->totalQuantity;
    }

    /**
     * @return mixed
     */
    public function getBillImage()
    {
        return $this->billImage;
    }

    /**
     * @param mixed $billImage
     */
    public function setBillImage($billImage): void
    {
        $this->billImage = $billImage;
    }

    /**
     * @return string|null
     */
    public function getImageName(): ?string
    {
        return $this->imageName;
    }

    /**
     * @return string|null
     */
    public function getImagePath(): ?string
    {
        return $this->imagePath;
    }

    /**
     * @param string|null $imageName
     */
    public function setImageName(?string $imageName): void
    {
        $this->imageName = $imageName;
    }

    /**
     * @param string|null $imagePath
     */
    public function setImagePath(?string $imagePath): void
    {
        $this->imagePath = $imagePath;
    }

    public function getIndexData(Request $request) : CustomResponse
    {
        return $this->supplierBillUseCases->getIndexData($this);
    }

    public function save(Request $request) : CustomResponse
    {

        $supplierBillViewModel = json_decode($request->supplierBillViewModel,true);

        $supplierBillInputValidationResponse = $this->checkInputValidation(
            $supplierBillViewModel,
            $this->validationFields
        );

        if($supplierBillInputValidationResponse != CustomResponseMsg::OK->value){
            return (new CustomResponse())->setResponse(
                CustomResponseCode::ERROR->value,
                $supplierBillInputValidationResponse
            );
        }

        if($request->hasFile('billImage')){
            $imageValidationResponse = $this->checkInputValidation($request->all(),[
                'billImage' => 'mimes:jpg,png|max:2048'
            ]);

            if($imageValidationResponse != CustomResponseMsg::OK->value){
                return (new CustomResponse())->setResponse(CustomResponseCode::ERROR->value, $imageValidationResponse);
            }
        }

        $file = $request->hasFile('billImage') ? $request->file("billImage") : null;

        $this->prepareViewModel($request,$supplierBillViewModel);
        $this->setBillImage($file);
        $this->setImagePath(null);
        $this->setImageName(null);

        return $this->supplierBillUseCases->save($this);
    }

    public function update(Request $request) : CustomResponse
    {
        $supplierBillViewModel = json_decode($request->supplierBillViewModel,true);

        $supplierInputValidationResponse = $this->checkInputValidation(
            $supplierBillViewModel,
            array_merge($this->validationFieldForId,$this->validationFields)
        );

        if($supplierInputValidationResponse != CustomResponseMsg::OK->value){
            return (new CustomResponse())->setResponse(CustomResponseCode::ERROR->value, $supplierInputValidationResponse);
        }

        if($request->hasFile('billImage')){
            $imageValidationResponse = $this->checkInputValidation($request->all(),[
                'billImage' => 'mimes:jpg,png|max:2048'
            ]);

            if($imageValidationResponse != CustomResponseMsg::OK->value){
                return (new CustomResponse())->setResponse(CustomResponseCode::ERROR->value, $imageValidationResponse);
            }
        }

        $file = $request->hasFile('billImage') ? $request->file("billImage") : null;

        $this->setId($supplierBillViewModel["id"]);
        $this->setBillImage($file);
        $this->setImagePath($supplierBillViewModel["imagePath"]);
        $this->setImageName($supplierBillViewModel["imageName"]);
        $this->prepareViewModel($request,$supplierBillViewModel);
        return $this->supplierBillUseCases->update($this);
    }

    public function prepareViewModel(Request $request,$supplierBillViewModel){
        $this->setSupplierId($supplierBillViewModel["supplierId"]);
        $this->setBillNumber($supplierBillViewModel["billNumber"]);
        $this->setBillingDate($supplierBillViewModel["billingDate"]);
        $this->setDebitAmount($supplierBillViewModel["debitAmount"]);
        $this->setTotalQuantity($supplierBillViewModel["totalQuantity"]);
        $this->setModifiedBy($request->modifiedBy);
        $this->setIp($request->ip());
    }

    public function remove(Request $request) : CustomResponse
    {
        $inputValidationResponse = $this->checkInputValidation(
            $request->supplierBillViewModel,
            $this->validationFieldForId
        );

        if($inputValidationResponse != CustomResponseMsg::OK->value){
            return (new CustomResponse())->setResponse(CustomResponseCode::ERROR->value, $inputValidationResponse);
        }

        $this->setId($request->supplierBillViewModel["id"]);
        $this->setImageName($request->supplierBillViewModel["imageName"]);
        return $this->supplierBillUseCases->remove($this);
    }

}
