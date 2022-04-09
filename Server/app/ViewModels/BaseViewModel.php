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

    public function __construct(
        CustomResponse $customResponse,
        FabricUseCase $fabricUseCase,
        CustomRequest $customRequest)
    {
        $this->customResponse = $customResponse;
        $this->fabricUseCase = $fabricUseCase;
        $this->customRequest = $customRequest;
    }

    public function checkAuthValidation(Request $request,OperationType $opType) : CustomResponse
    {

        $validator = Validator::make($request->userInfo,[
            'email' => 'required|email',
            'href' => 'required|string',
            'sessionId' => 'required|string',
        ]);

        if($validator->fails()){
            $this->customResponse->code = CustomResponseCode::ERROR->value;
            $this->customResponse->msg =  $validator->errors()->first();

        }else{
            $this->customResponse->code = CustomResponseCode::SUCCESS->value;
            $this->customResponse->msg =  CustomResponseMsg::SUCCESS->value;
        }

        return $this->customResponse;
    }


}
