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

    public function __construct(FabricUseCase $fabricUseCase)
    {
        $this->fabricUseCase = $fabricUseCase;
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

    public function checkAuthValidation(Request $request,OperationType $opType) : string
    {
        $authMsg = CustomResponseMsg::OK->value;

        $validator = Validator::make($request->userInfo,[
            'email' => 'required|email',
            'href' => 'required|string',
            'sessionId' => 'required|string',
        ]);

        if($validator->fails()){
            $authMsg = $validator->errors()->first();
        }

        return $authMsg;
    }

    public function checkInputValidation($viewModel, array $rules) : string
    {

        $validationMsg = CustomResponseMsg::OK->value;

        $validator = Validator::make($viewModel, $rules);

        if($validator->fails()){
            $validationMsg = $validator->errors()->first();
        }

        return $validationMsg;
    }

}
