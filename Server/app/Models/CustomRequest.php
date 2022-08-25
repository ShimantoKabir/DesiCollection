<?php

namespace App\Models;

use App\ViewModels\FabricViewModel;

class CustomRequest
{
    public FabricViewModel $fabricViewModel;
    public ?string $firstName;
    public ?string $mobileNumber;

    /**
     * @return string|null
     */
    public function getFirstName(): ?string
    {
        return $this->firstName;
    }

    /**
     * @param string|null $firstName
     */
    public function setFirstName(?string $firstName): void
    {
        $this->firstName = $firstName;
    }

    /**
     * @return string|null
     */
    public function getMobileNumber(): ?string
    {
        return $this->mobileNumber;
    }

    /**
     * @param string|null $mobileNumber
     */
    public function setMobileNumber(?string $mobileNumber): void
    {
        $this->mobileNumber = $mobileNumber;
    }

}
