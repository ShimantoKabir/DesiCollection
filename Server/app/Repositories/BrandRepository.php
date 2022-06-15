<?php

namespace App\Repositories;

use App\Enums\CustomResponseCode;
use App\Enums\CustomResponseMsg;
use App\Models\Brand;
use App\Models\CustomResponse;
use App\Repositories\Interfaces\IBrandRepository;
use App\ViewModels\BrandViewModel;
use Illuminate\Support\Facades\DB;

class BrandRepository extends BaseRepository implements IBrandRepository
{

    public function read(): array
    {
        return Brand::select(
            "id",
            "brandName",
            DB::raw($this->getImageRawSql("imageName","imagePath")),
            "imageName"
        )->get()->toArray();
    }

    public function getIndexData(): CustomResponse
    {
        $res = new CustomResponse();
        $res->setCode(CustomResponseCode::SUCCESS->value);
        $res->setMsg(CustomResponseMsg::INIT_SUCCESS->value);
        $res->setBrands($this->read());
        return $res;
    }

    public function create(BrandViewModel $brandViewModel): CustomResponse
    {
        $date = $this->getCurrentDate();
        $res = new CustomResponse();
        DB::beginTransaction();
        try{

            $model = new Brand();
            $model->brandName = $brandViewModel->getBrandName();
            $model->imageName = $brandViewModel->getImageName();
            $model->createdAt = $date;
            $model->ip = $brandViewModel->getIp();
            $model->modifiedBy = $brandViewModel->getModifiedBy();
            $model->save();

            $model->imagePath = $this->getAssetPrefix().$brandViewModel->getImageName();

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

    public function update(BrandViewModel $brandViewModel): CustomResponse
    {
        $date = $this->getCurrentDate();
        $res = new CustomResponse();
        DB::beginTransaction();
        try{

            Brand::where('id',$brandViewModel->id)
                ->update([
                    'brandName' => $brandViewModel->getBrandName(),
                    'imageName' => $brandViewModel->getImageName(),
                    'ip' => $brandViewModel->getIp(),
                    'updatedAt' => $date,
                    'modifiedBy' => $brandViewModel->getModifiedBy()
                ]);

            $brandViewModel->setImagePath($this->getAssetPrefix().$brandViewModel->getImageName());

            DB::commit();
            $res->setCode(CustomResponseCode::SUCCESS->value);
            $res->setMsg(CustomResponseMsg::SUCCESS->value);
            $res->setModel($brandViewModel);

        }catch (\Exception $e){
            $res->setCode(CustomResponseCode::ERROR->value);
            $res->setMsg($e->getMessage());
        }

        return $res;
    }

    public function delete(BrandViewModel $brandViewModel): CustomResponse
    {
        $res = new CustomResponse();
        DB::beginTransaction();
        try{

            Brand::where('id',$brandViewModel->getId())->delete();
            DB::commit();

            $res->setCode(CustomResponseCode::SUCCESS->value);
            $res->setMsg(CustomResponseMsg::SUCCESS->value);

        }catch (\Exception $e){
            $res->setCode(CustomResponseCode::ERROR->value);
            $res->setMsg($e->getMessage());
        }

        return $res;
    }

    public function isBrandExist(BrandViewModel $brandViewModel): CustomResponse
    {
        $res = new CustomResponse();
        $isExist = Brand::where('brandName',$brandViewModel->getBrandName())
            ->exists();

        if($isExist){
            $res->setCode(CustomResponseCode::ERROR->value);
            $res->setMsg(CustomResponseMsg::BRAND_EXIST->value);
        }else{
            $res->setCode(CustomResponseCode::SUCCESS->value);
            $res->setMsg(CustomResponseMsg::SUCCESS->value);
        }

        return $res;
    }
}
