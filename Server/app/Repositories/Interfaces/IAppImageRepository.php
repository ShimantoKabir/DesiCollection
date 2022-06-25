<?php

namespace App\Repositories\Interfaces;

use App\Models\AppImageViewModel;
use App\Models\CustomResponse;

interface IAppImageRepository extends IBaseRepository
{
    public function create(AppImageViewModel $appImageViewModel) : CustomResponse;
    public function update(AppImageViewModel $appImageViewModel) : CustomResponse;
    public function delete(AppImageViewModel $appImageViewModel) : CustomResponse;
    public function readByReferenceId(int $referenceId) : array;
    public function readyByIds(array $ids): array;
    public function deleteByIds(array $ids): CustomResponse;
    public function deleteByReferenceId(int $referenceId) : CustomResponse;
}
