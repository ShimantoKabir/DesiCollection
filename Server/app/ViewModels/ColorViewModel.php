<?php

namespace App\ViewModels;

class ColorViewModel extends BaseViewModel
{
    public int $id;
    public string $colorName;
    public ?string $ip;
    public ?int $modifiedBy;
    public array $colors;
    public ?object $model;

    /**
     * @param int $id
     */
    public function setId(int $id): void
    {
        $this->id = $id;
    }

    /**
     * @return int
     */
    public function getId(): int
    {
        return $this->id;
    }

    /**
     * @param string $colorName
     */
    public function setColorName(string $colorName): void
    {
        $this->colorName = $colorName;
    }

    /**
     * @return string
     */
    public function getColorName(): string
    {
        return $this->colorName;
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

    /**
     * @return object|null
     */
    public function getModel(): ?object
    {
        return $this->model;
    }

    /**
     * @param object|null $model
     */
    public function setModel(?object $model): void
    {
        $this->model = $model;
    }

    /**
     * @return array
     */
    public function getColors(): array
    {
        return $this->colors;
    }

    /**
     * @param array $colors
     */
    public function setColors(array $colors): void
    {
        $this->colors = $colors;
    }

}
