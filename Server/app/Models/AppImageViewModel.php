<?php

namespace App\Models;

use App\ViewModels\BaseViewModel;

class AppImageViewModel extends BaseViewModel
{
    public string $imageName;
    public int $imageType;
    public bool $isActive;
    public int $referenceId;
    public string $imagePath;

    /**
     * @param string $imageName
     */
    public function setImageName(string $imageName): void
    {
        $this->imageName = $imageName;
    }

    /**
     * @return string
     */
    public function getImageName(): string
    {
        return $this->imageName;
    }

    /**
     * @return int
     */
    public function getImageType(): int
    {
        return $this->imageType;
    }

    /**
     * @param int $imageType
     */
    public function setImageType(int $imageType): void
    {
        $this->imageType = $imageType;
    }

    /**
     * @param int $isActive
     */
    public function setIsActive(int $isActive): void
    {
        $this->isActive = $isActive;
    }

    /**
     * @return bool
     */
    public function isActive(): bool
    {
        return $this->isActive;
    }

    /**
     * @param int $referenceId
     */
    public function setReferenceId(int $referenceId): void
    {
        $this->referenceId = $referenceId;
    }

    /**
     * @return int
     */
    public function getReferenceId(): int
    {
        return $this->referenceId;
    }

    /**
     * @param string $imagePath
     */
    public function setImagePath(string $imagePath): void
    {
        $this->imagePath = $imagePath;
    }

    /**
     * @return string
     */
    public function getImagePath(): string
    {
        return $this->imagePath;
    }


}
