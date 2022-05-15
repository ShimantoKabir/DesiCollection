<?php

namespace App\UseCases;

use App\Enums\CustomResponseCode;
use App\Models\CustomResponse;
use App\Repositories\BrandRepository;
use App\ViewModels\BrandViewModel;

class BrandUseCase extends BaseUseCase
{

    private BrandRepository $brandRepository;

    public function __construct(BrandRepository $brandRepository)
    {
        $this->brandRepository = $brandRepository;
    }

    public function getIndexData() : CustomResponse
    {
        return $this->brandRepository->getIndexData();
    }

    public function save(BrandViewModel $brandViewModel) : CustomResponse
    {
        $existResponse = $this->brandRepository->isBrandExist($brandViewModel);

        if($existResponse->code == CustomResponseCode::ERROR->value){
            return $existResponse;
        }else{
            if (!is_null($brandViewModel->getBrandImage())){
                $brandImageName = $this->brandRepository->uploadFileToFtp($brandViewModel->getBrandImage());
                $brandViewModel->setImageName($brandImageName);
            }
            return $this->brandRepository->create($brandViewModel);
        }
    }

    public function update(BrandViewModel $brandViewModel) : CustomResponse
    {
        if (!is_null($brandViewModel->getImageName()) &&
            $this->brandRepository->IsFileExistInFtp($brandViewModel->getImageName())){
            $isDeleted = $this->brandRepository->deleteFileFromFtp($brandViewModel->getImageName());
            if ($isDeleted){
                $brandViewModel->setImageName(null);
            }
        }

        if (!is_null($brandViewModel->getBrandImage())){
            $brandImageName = $this->brandRepository->uploadFileToFtp($brandViewModel->getBrandImage());
            $brandViewModel->setImageName($brandImageName);
        }

        return $this->brandRepository->update($brandViewModel);
    }

    public function remove(BrandViewModel $brandViewModel) : CustomResponse
    {

        if (!is_null($brandViewModel->getImageName()) &&
            $this->brandRepository->IsFileExistInFtp($brandViewModel->getImageName())){
            $this->brandRepository->deleteFileFromFtp($brandViewModel->getImageName());
        }

        return $this->brandRepository->delete($brandViewModel);
    }

}
