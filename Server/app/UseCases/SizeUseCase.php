<?php

namespace App\UseCases;

use App\Enums\CustomResponseCode;
use App\Models\CustomResponse;
use App\Repositories\SizeRepository;
use App\ViewModels\SizeViewModel;

class SizeUseCase extends BaseUseCase
{

    private SizeRepository $sizeRepository;

    public function __construct(SizeRepository $sizeRepository)
    {
        $this->sizeRepository = $sizeRepository;
    }

    public function getIndexData() : CustomResponse
    {
        return $this->sizeRepository->getIndexData();
    }

    public function save(SizeViewModel $sizeViewModel) : CustomResponse
    {
        $existResponse = $this->sizeRepository->isSizeNameExist($sizeViewModel->sizeName);

        if($existResponse->code == CustomResponseCode::ERROR->value){
            return $existResponse;
        }else{
            return $this->sizeRepository->create($sizeViewModel);
        }
    }

    public function update(SizeViewModel $sizeViewModel) : CustomResponse
    {
        $existResponse = $this->sizeRepository->isSizeNameExist($sizeViewModel->sizeName);

        if($existResponse->code == CustomResponseCode::ERROR->value){
            return $existResponse;
        }else{
            return $this->sizeRepository->update($sizeViewModel);
        }
    }

    public function remove(SizeViewModel $sizeViewModel) : CustomResponse
    {
        return $this->sizeRepository->delete($sizeViewModel);
    }

}
