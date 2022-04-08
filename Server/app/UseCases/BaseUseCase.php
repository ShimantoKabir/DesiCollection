<?php

namespace App\UseCases;

use App\Repositories\FabricRepository;
use JetBrains\PhpStorm\Pure;

class BaseUseCase
{
    public FabricRepository $fabricRepository;

    #[Pure] public function __construct(FabricRepository $fabricRepository)
    {
        $this->fabricRepository = $fabricRepository;
    }

}
