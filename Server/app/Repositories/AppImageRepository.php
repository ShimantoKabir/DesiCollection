<?php

namespace App\Repositories;

use App\Enums\CustomResponseCode;
use App\Enums\CustomResponseMsg;
use App\Models\AppImage;
use App\Models\AppImageViewModel;
use App\Models\CustomResponse;
use App\Repositories\Interfaces\IAppImageRepository;
use Illuminate\Support\Facades\DB;

class AppImageRepository extends BaseRepository implements IAppImageRepository
{
    public function create(AppImageViewModel $appImageViewModel): CustomResponse
    {
        $date = $this->getCurrentDate();
        $res = new CustomResponse();
        DB::beginTransaction();
        try{

            $model = new AppImage();
            $model->imageName = $appImageViewModel->getImageName();
            $model->imageType = $appImageViewModel->getImageType();
            $model->isActive = $appImageViewModel->isActive();
            $model->referenceId = $appImageViewModel->getReferenceId();
            $model->ip = $appImageViewModel->getIp();
            $model->createdAt = $date;
            $model->modifiedBy = $appImageViewModel->getModifiedBy();
            $model->save();

            $model->imagePath = $this->getAssetPrefix().$appImageViewModel->getImageName();

            $res->setModel($model);
            $res->setCode(CustomResponseCode::SUCCESS->value);
            $res->setMsg(CustomResponseMsg::SUCCESS->value);

            DB::commit();

        }catch (\Exception $e){
            $res->setCode(CustomResponseCode::ERROR->value);
            $res->setMsg($e->getMessage());
        }

        return $res;
    }

    public function update(AppImageViewModel $appImageViewModel): CustomResponse
    {
        $date = $this->getCurrentDate();
        $res = new CustomResponse();
        DB::beginTransaction();
        try{

            AppImage::where('id',$appImageViewModel->id)
            ->update([
                'imageName' => $appImageViewModel->getImageName(),
                'imageType' => $appImageViewModel->getImageType(),
                'isActive' => $appImageViewModel->isActive(),
                'referenceId' => $appImageViewModel->getReferenceId(),
                'ip' => $appImageViewModel->getIp(),
                'updatedAt' => $date,
                'modifiedBy' => $appImageViewModel->getModifiedBy()
            ]);

            $appImageViewModel->setImagePath($this->getAssetPrefix().$appImageViewModel->getImageName());

            DB::commit();
            $res->setCode(CustomResponseCode::SUCCESS->value);
            $res->setMsg(CustomResponseMsg::SUCCESS->value);
            $res->setModel($appImageViewModel);

        }catch (\Exception $e){
            $res->setCode(CustomResponseCode::ERROR->value);
            $res->setMsg($e->getMessage());
        }

        return $res;
    }

    public function delete(AppImageViewModel $appImageViewModel): CustomResponse
    {
        $res = new CustomResponse();
        DB::beginTransaction();
        try{

            AppImage::where('id',$appImageViewModel->getId())->delete();
            DB::commit();

            $res->setCode(CustomResponseCode::SUCCESS->value);
            $res->setMsg(CustomResponseMsg::SUCCESS->value);

        }catch (\Exception $e){
            $res->setCode(CustomResponseCode::ERROR->value);
            $res->setMsg($e->getMessage());
        }

        return $res;
    }

    public function read(): array
    {
        return [];
    }

    /**
     * @param int $referenceId
     * @return array
     */
    public function readByReferenceId(int $referenceId): array
    {
        return AppImage::select(
            "id",
            "isActive",
            "imageName",
            "imageType",
            "referenceId",
            DB::raw($this->getImageRawSql("imageName","imagePath"))
        )->where("referenceId",$referenceId)->get()->toArray();
    }
}
