<?php

namespace App\UseCases;

use App\Models\CustomRequest;
use App\Models\CustomResponse;
use JetBrains\PhpStorm\Pure;

class BaseUseCase
{
    public CustomRequest $customRequest;
    public CustomResponse $customResponse;

    #[Pure] public function __construct(
        CustomRequest $customRequest,
        CustomResponse $customResponse)
    {
        $this->customRequest = $customRequest;
        $this->customResponse = $customResponse;
    }

}
