<?php

namespace App\ViewModels;

use App\Enums\CustomResponseCode;
use App\Enums\CustomResponseMsg;
use App\Enums\OperationType;
use App\Models\CustomRequest;
use App\Models\CustomResponse;
use App\UseCases\FabricUseCase;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class BaseViewModel
{

    public CustomResponse $customResponse;
    public FabricUseCase $fabricUseCase;
    public CustomRequest $customRequest;
    public string $msg;
    public int $code;
    public string $ip;
    public array $data;

    public function __construct(
        CustomResponse $customResponse,
        FabricUseCase $fabricUseCase,
        CustomRequest $customRequest)
    {
        $this->customResponse = $customResponse;
        $this->fabricUseCase = $fabricUseCase;
        $this->customRequest = $customRequest;
    }

    public function setCode(int $code){
        $this->code = $code;
    }

    public function setMsg(string $msg){
        $this->msg = $msg;
    }

    public function setData(array $data){
        $this->data = $data;
    }

    public function checkAuthValidation(Request $request,OperationType $opType) : CustomResponse
    {

        $validator = Validator::make($request->userInfo,[
            'email' => 'required|email',
            'href' => 'required|string',
            'sessionId' => 'required|string',
        ]);

        if($validator->fails()){
            $this->customResponse->setCode(CustomResponseCode::ERROR->value);
            $this->customResponse->setMsg($validator->errors()->first());

        }else{
            $this->customResponse->setCode(CustomResponseCode::SUCCESS->value);
            $this->customResponse->setMsg(CustomResponseMsg::SUCCESS->value);
            $this->customResponse->setModifiedBy(0);
        }

        return $this->customResponse;
    }


}
