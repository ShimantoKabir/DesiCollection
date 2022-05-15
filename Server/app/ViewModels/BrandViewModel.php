<?php

namespace App\ViewModels;

use App\Enums\CustomResponseCode;
use App\Enums\CustomResponseMsg;
use App\Enums\OperationType;
use App\Models\CustomResponse;
use App\UseCases\BrandUseCase;
use Illuminate\Http\Request;

class BrandViewModel extends BaseViewModel
{

    public int $id;
    public string $brandName;
    public ?string $imageName;
    public string $ip;
    public int $modifiedBy;
    public array $brands;
    public object $model;
    public $brandImage;
    public ?string $imagePath;

    public BrandUseCase $brandUseCase;

    public function __construct(BrandUseCase $brandUseCase)
    {
        $this->brandUseCase = $brandUseCase;
    }

    public function setId(int $id)
    {
        $this->id = $id;
    }

    public function setBrandName(string $brandName)
    {
        $this->brandName = $brandName;
    }

    public function getBrandName() : string
    {
        return $this->brandName;
    }

    public function setImageName(?string $imageName)
    {
        $this->imageName = $imageName;
    }

    public function getImageName() : ?string
    {
        return $this->imageName;
    }

    public function setBrandImage($brandImage)
    {
        $this->brandImage = $brandImage;
    }

    public function getBrandImage(){
        return $this->brandImage;
    }

    public function setIp(string $ip)
    {
        $this->ip = $ip;
    }

    public function getIp() : string
    {
        return $this->ip;
    }

    public function setModifiedBy(int $modifiedBy)
    {
        $this->modifiedBy = $modifiedBy;
    }

    public function getModifiedBy() : string
    {
        return $this->modifiedBy;
    }

    public function setImagePath(?string $imagePath)
    {
        $this->imagePath = $imagePath;
    }

    public function getImagePath() : ?string
    {
        return $this->imagePath;
    }

    public function getIndexData(Request $request) : CustomResponse
    {
        $authResponse = $this->checkAuthValidation($request,OperationType::READ);

        if($authResponse != CustomResponseMsg::OK->value){
            return (new CustomResponse())->setResponse(CustomResponseCode::ERROR->value, $authResponse);
        }

        return $this->brandUseCase->getIndexData();
    }

    public function save(Request $request) : CustomResponse
    {

        $brandViewModel = json_decode($request->brandViewModel,true);
        $userInfo = json_decode($request->userInfo,true);

        $authResponse = $this->checkAuthObjValidation($userInfo,OperationType::CREATE);

        if($authResponse != CustomResponseMsg::OK->value){
            return (new CustomResponse())->setResponse(CustomResponseCode::ERROR->value, $authResponse);
        }

        $inputValidationResponse = $this->checkInputValidation($brandViewModel,[
            'brandName' => 'required|string'
        ]);

        if($inputValidationResponse != CustomResponseMsg::OK->value){
            return (new CustomResponse())->setResponse(CustomResponseCode::ERROR->value, $inputValidationResponse);
        }

        if($request->hasFile('brandImage')){
            $imageValidationResponse = $this->checkInputValidation($request->all(),[
                'brandImage' => 'mimes:jpg,png|max:2048'
            ]);

            if($imageValidationResponse != CustomResponseMsg::OK->value){
                return (new CustomResponse())->setResponse(CustomResponseCode::ERROR->value, $imageValidationResponse);
            }
        }

        $this->setBrandName($brandViewModel["brandName"]);
        $request->hasFile('brandImage') ? $this->setBrandImage($request->file("brandImage"))
            : $this->setBrandImage(null);
        $this->setImagePath(null);
        $this->setImageName(null);
        $this->setIp($request->ip());
        $this->setModifiedBy(0);

        return $this->brandUseCase->save($this);

    }

    public function update(Request $request) : CustomResponse
    {

        $brandViewModel = json_decode($request->brandViewModel,true);
        $userInfo = json_decode($request->userInfo,true);

        $authResponse = $this->checkAuthObjValidation($userInfo,OperationType::CREATE);

        if($authResponse != CustomResponseMsg::OK->value){
            return (new CustomResponse())->setResponse(CustomResponseCode::ERROR->value, $authResponse);
        }

        $inputValidationResponse = $this->checkInputValidation($brandViewModel,[
            'brandName' => 'required|string'
        ]);

        if($inputValidationResponse != CustomResponseMsg::OK->value){
            return (new CustomResponse())->setResponse(CustomResponseCode::ERROR->value, $inputValidationResponse);
        }

        if($request->hasFile('brandImage')){
            $imageValidationResponse = $this->checkInputValidation($request->all(),[
                'brandImage' => 'mimes:jpg,png|max:2048'
            ]);

            if($imageValidationResponse != CustomResponseMsg::OK->value){
                return (new CustomResponse())->setResponse(CustomResponseCode::ERROR->value, $imageValidationResponse);
            }
        }

        $file = $request->hasFile('brandImage') ? $request->file("brandImage") : null;

        $this->setId($brandViewModel["id"]);
        $this->setBrandName($brandViewModel["brandName"]);
        $this->setBrandImage($file);
        $this->setImagePath($brandViewModel["imagePath"]);
        $this->setImageName($brandViewModel["imageName"]);
        $this->setIp($request->ip());
        $this->setModifiedBy(0);

        return $this->brandUseCase->update($this);
    }

    public function remove(Request $request) : CustomResponse
    {

        $authResponse = $this->checkAuthValidation($request,OperationType::CREATE);

        if($authResponse != CustomResponseMsg::OK->value){
            return (new CustomResponse())->setResponse(CustomResponseCode::ERROR->value, $authResponse);
        }

        $inputValidationResponse = $this->checkInputValidation($request->brandViewModel,[
            'id' => 'required|int'
        ]);

        if($inputValidationResponse != CustomResponseMsg::OK->value){
            return (new CustomResponse())->setResponse(CustomResponseCode::ERROR->value, $inputValidationResponse);
        }

        $this->setId($request->brandViewModel["id"]);
        $this->setImageName($request->brandViewModel["imageName"]);
        return $this->brandUseCase->remove($this);
    }

}
