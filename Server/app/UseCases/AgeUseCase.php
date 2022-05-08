<?php

namespace App\UseCases;

use App\Enums\CustomResponseCode;
use App\Models\CustomResponse;
use App\Repositories\AgeRepository;
use App\ViewModels\AgeViewModel;

class AgeUseCase extends BaseUseCase
{
    private AgeRepository $ageRepository;

    public function __construct(AgeRepository $ageRepository)
    {
        $this->ageRepository = $ageRepository;
    }

    public function getIndexData() : CustomResponse
    {
        return $this->ageRepository->getIndexData();
    }

    public function save(AgeViewModel $ageViewModel) : CustomResponse
    {
        $existResponse = $this->ageRepository
            ->isAgeExist($ageViewModel->minAge,$ageViewModel->maxAge,$ageViewModel->fixedAge);

        if($existResponse->code == CustomResponseCode::ERROR->value){
            return $existResponse;
        }else{
            return $this->ageRepository->create($ageViewModel);
        }
    }

    public function update(AgeViewModel $ageViewModel) : CustomResponse
    {
        $existResponse = $this->ageRepository
            ->isAgeExist($ageViewModel->minAge,$ageViewModel->maxAge,$ageViewModel->fixedAge);

        if($existResponse->code == CustomResponseCode::ERROR->value){
            return $existResponse;
        }else{
            return $this->ageRepository->update($ageViewModel);
        }
    }

    public function remove(AgeViewModel $ageViewModel) : CustomResponse
    {
        return $this->ageRepository->delete($ageViewModel);
    }
}
