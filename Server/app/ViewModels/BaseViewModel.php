<?php

namespace App\ViewModels;

use App\Enums\CustomResponseMsg;
use App\Enums\OperationType;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class BaseViewModel
{
    public ?int $id;
    public ?string $ip;
    public ?int $modifiedBy;
    public array $validationFieldForId = [
        'id' => 'required|int'
    ];

    /**
     * @param int|null $id
     */
    public function setId(?int $id): void
    {
        $this->id = $id;
    }

    /**
     * @return int|null
     */
    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * @param string|null $ip
     */
    public function setIp(?string $ip): void
    {
        $this->ip = $ip;
    }

    /**
     * @return string|null
     */
    public function getIp(): ?string
    {
        return $this->ip;
    }

    /**
     * @param int|null $modifiedBy
     */
    public function setModifiedBy(?int $modifiedBy): void
    {
        $this->modifiedBy = $modifiedBy;
    }

    /**
     * @return int|null
     */
    public function getModifiedBy(): ?int
    {
        return $this->modifiedBy;
    }

    public function checkAuthValidation(Request $request,OperationType $opType) : string
    {
        $authMsg = CustomResponseMsg::OK->value;

        $validator = Validator::make($request->userInfo,[
            'email' => 'required|email',
            'href' => 'required|string',
            'sessionId' => 'required|string'
        ]);

        if($validator->fails()){
            $authMsg = $validator->errors()->first();
        }

        return $authMsg;
    }

    public function checkAuthObjValidation($userInfo,OperationType $opType) : string
    {
        $authMsg = CustomResponseMsg::OK->value;

        $validator = Validator::make($userInfo,[
            'email' => 'required|email',
            'href' => 'required|string',
            'sessionId' => 'required|string'
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
