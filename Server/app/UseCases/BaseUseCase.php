<?php

namespace App\UseCases;

use App\Models\CustomRequest;
use App\Repositories\FabricRepository;
use JetBrains\PhpStorm\Pure;

class BaseUseCase
{
    public FabricRepository $fabricRepository;
    public CustomRequest $customRequest;

    #[Pure] public function __construct(FabricRepository $fabricRepository,CustomRequest $customRequest)
    {
        $this->fabricRepository = $fabricRepository;
        $this->customRequest = $customRequest;
    }

}
