<?php

namespace App\Repositories;

use App\Enums\AppConstants;
use Illuminate\Support\Facades\Storage;

class BaseRepository
{

    public function getCurrentDate() : string
    {
        return date('Y-m-d H:i:s');
    }

    public function getAssetPrefix() : string
    {
        return env("FTP_PROTOCOL").env('FTP_HOST').":".env("APP_PORT").AppConstants::FTP_URL_PREFIX->value;
    }

    public function uploadFileToFtp($file) : ?string
    {
        if(!is_null($file)){
            $filenameWithExtension = $file->getClientOriginalName();
            $filename = pathinfo($filenameWithExtension, PATHINFO_FILENAME);
            $filename = str_replace(' ', '_', $filename);
            $extension = $file->getClientOriginalExtension();
            $finalFileName = $filename.'_'.uniqid().'.'.$extension;
            $fileNameWithPath = AppConstants::FTP_URL_PREFIX->value.$finalFileName;
            Storage::disk('ftp')->put($fileNameWithPath, fopen($file, 'r+'));

            return $finalFileName;

        }else{
            return null;
        }
    }

    public function deleteFileFromFtp($fileName) : bool
    {
        $filePath = AppConstants::FTP_URL_PREFIX->value.$fileName;
        return Storage::disk("ftp")->delete($filePath);
    }

    public function IsFileExistInFtp($fileName) : bool
    {
        $filePath = AppConstants::FTP_URL_PREFIX->value.$fileName;
        return Storage::disk("ftp")->exists($filePath);
    }

    public function getImageRawSql(string $columnName,string $aliseColumnName) : string
    {
        return sprintf("concat('%s',%s) as %s",$this->getAssetPrefix(),$columnName,$aliseColumnName);
    }

}
