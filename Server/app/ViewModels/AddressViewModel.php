<?php

namespace App\ViewModels;

class AddressViewModel extends BaseViewModel
{
    public ?int $id;
    public string $city;
    public string $email;
    public ?string $detail;
    public ?string $country;
    public string $zipCode;
    public ?int $addressType;
    public ?int $linkUpId;
    public string $firstMobileNo;
    public ?string $secondMobileNo;
    public ?string $ip;
    public ?string $createdAt;
    public ?string $updatedAt;
    public ?int $modifiedBy;

    /**
     * @return int|null
     */
    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * @param int|null $id
     */
    public function setId(?int $id): void
    {
        $this->id = $id;
    }

    /**
     * @return string
     */
    public function getCity(): string
    {
        return $this->city;
    }

    /**
     * @param string $city
     */
    public function setCity(string $city): void
    {
        $this->city = $city;
    }

    /**
     * @return string
     */
    public function getEmail(): string
    {
        return $this->email;
    }

    /**
     * @param string $email
     */
    public function setEmail(string $email): void
    {
        $this->email = $email;
    }

    /**
     * @return string|null
     */
    public function getDetail(): ?string
    {
        return $this->detail;
    }

    /**
     * @param string|null $detail
     */
    public function setDetail(?string $detail): void
    {
        $this->detail = $detail;
    }

    /**
     * @return string|null
     */
    public function getCountry(): ?string
    {
        return $this->country;
    }

    /**
     * @param string|null $country
     */
    public function setCountry(?string $country): void
    {
        $this->country = $country;
    }

    /**
     * @return string
     */
    public function getZipCode(): string
    {
        return $this->zipCode;
    }

    /**
     * @param string $zipCode
     */
    public function setZipCode(string $zipCode): void
    {
        $this->zipCode = $zipCode;
    }

    /**
     * @return int|null
     */
    public function getAddressType(): ?int
    {
        return $this->addressType;
    }

    /**
     * @param int|null $addressType
     */
    public function setAddressType(?int $addressType): void
    {
        $this->addressType = $addressType;
    }

    /**
     * @return int|null
     */
    public function getLinkUpId(): ?int
    {
        return $this->linkUpId;
    }

    /**
     * @param int|null $linkUpId
     */
    public function setLinkUpId(?int $linkUpId): void
    {
        $this->linkUpId = $linkUpId;
    }

    /**
     * @return string
     */
    public function getFirstMobileNo(): string
    {
        return $this->firstMobileNo;
    }

    /**
     * @param string $firstMobileNo
     */
    public function setFirstMobileNo(string $firstMobileNo): void
    {
        $this->firstMobileNo = $firstMobileNo;
    }

    /**
     * @return string|null
     */
    public function getSecondMobileNo(): ?string
    {
        return $this->secondMobileNo;
    }

    /**
     * @param string|null $secondMobileNo
     */
    public function setSecondMobileNo(?string $secondMobileNo): void
    {
        $this->secondMobileNo = $secondMobileNo;
    }

    /**
     * @return string|null
     */
    public function getIp(): ?string
    {
        return $this->ip;
    }

    /**
     * @param string|null $ip
     */
    public function setIp(?string $ip): void
    {
        $this->ip = $ip;
    }

    /**
     * @param string|null $createdAt
     */
    public function setCreatedAt(?string $createdAt): void
    {
        $this->createdAt = $createdAt;
    }

    /**
     * @return string|null
     */
    public function getCreatedAt(): ?string
    {
        return $this->createdAt;
    }

    /**
     * @param string|null $updatedAt
     */
    public function setUpdatedAt(?string $updatedAt): void
    {
        $this->updatedAt = $updatedAt;
    }

    /**
     * @return string|null
     */
    public function getUpdatedAt(): ?string
    {
        return $this->updatedAt;
    }

    /**
     * @return int|null
     */
    public function getModifiedBy(): ?int
    {
        return $this->modifiedBy;
    }

    /**
     * @param int|null $modifiedBy
     */
    public function setModifiedBy(?int $modifiedBy): void
    {
        $this->modifiedBy = $modifiedBy;
    }


}
