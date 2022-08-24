<?php

namespace App\ViewModels;

use App\Models\CustomResponse;
use App\UseCases\UserInfoUseCase;
use Illuminate\Http\Request;

class UserInfoViewModel extends BaseViewModel
{
    public ?int $id;
    public ?string $email;
    public ?string $token;
    public int $forWhom;
    public ?int $roleOid;
    public string $password;
    public ?string $lastName;
    public string $opAccess;
    public ?string $userName;
    public bool $isActive;
    public ?string $sessionId;
    public ?string $firstName;
    public bool $isApproved;
    public ?string $mobileNumber;
    public ?string $socialLoginId;
    public ?string $restrictedMenuOid;
    public string $operation;
    public string $href;
    public UserInfoUseCase $userInfoUseCase;



    public function __construct(UserInfoUseCase $userInfoUseCase)
    {
        $this->userInfoUseCase = $userInfoUseCase;
    }

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
     * @param string|null $email
     */
    public function setEmail(?string $email): void
    {
        $this->email = $email;
    }

    /**
     * @return string|null
     */
    public function getEmail(): ?string
    {
        return $this->email;
    }

    /**
     * @return string|null
     */
    public function getToken(): ?string
    {
        return $this->token;
    }

    /**
     * @param string|null $token
     */
    public function setToken(?string $token): void
    {
        $this->token = $token;
    }

    /**
     * @return int
     */
    public function getForWhom(): int
    {
        return $this->forWhom;
    }

    /**
     * @param int $forWhom
     */
    public function setForWhom(int $forWhom): void
    {
        $this->forWhom = $forWhom;
    }

    /**
     * @return int|null
     */
    public function getRoleOid(): ?int
    {
        return $this->roleOid;
    }

    /**
     * @param int|null $roleOid
     */
    public function setRoleOid(?int $roleOid): void
    {
        $this->roleOid = $roleOid;
    }

    /**
     * @return string
     */
    public function getPassword(): string
    {
        return $this->password;
    }

    /**
     * @param string $password
     */
    public function setPassword(string $password): void
    {
        $this->password = $password;
    }

    /**
     * @return string|null
     */
    public function getLastName(): ?string
    {
        return $this->lastName;
    }

    /**
     * @param string|null $lastName
     */
    public function setLastName(?string $lastName): void
    {
        $this->lastName = $lastName;
    }

    /**
     * @return string
     */
    public function getOpAccess(): string
    {
        return $this->opAccess;
    }

    /**
     * @param string $opAccess
     */
    public function setOpAccess(string $opAccess): void
    {
        $this->opAccess = $opAccess;
    }

    /**
     * @return string
     */
    public function getOperation(): string
    {
        return $this->operation;
    }

    /**
     * @param string $operation
     */
    public function setOperation(string $operation): void
    {
        $this->operation = $operation;
    }

    /**
     * @return string|null
     */
    public function getUserName(): ?string
    {
        return $this->userName;
    }

    /**
     * @param string|null $userName
     */
    public function setUserName(?string $userName): void
    {
        $this->userName = $userName;
    }

    /**
     * @param bool $isActive
     */
    public function setIsActive(bool $isActive): void
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
     * @return bool
     */
    public function isApproved(): bool
    {
        return $this->isApproved;
    }

    /**
     * @param bool $isApproved
     */
    public function setIsApproved(bool $isApproved): void
    {
        $this->isApproved = $isApproved;
    }

    /**
     * @return string|null
     */
    public function getSessionId(): ?string
    {
        return $this->sessionId;
    }

    /**
     * @param string|null $sessionId
     */
    public function setSessionId(?string $sessionId): void
    {
        $this->sessionId = $sessionId;
    }

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

    /**
     * @return string|null
     */
    public function getSocialLoginId(): ?string
    {
        return $this->socialLoginId;
    }

    /**
     * @param string|null $socialLoginId
     */
    public function setSocialLoginId(?string $socialLoginId): void
    {
        $this->socialLoginId = $socialLoginId;
    }

    /**
     * @return string|null
     */
    public function getRestrictedMenuOid(): ?string
    {
        return $this->restrictedMenuOid;
    }

    /**
     * @param string|null $restrictedMenuOid
     */
    public function setRestrictedMenuOid(?string $restrictedMenuOid): void
    {
        $this->restrictedMenuOid = $restrictedMenuOid;
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

    /**
     * @return string
     */
    public function getHref(): string
    {
        return $this->href;
    }

    /**
     * @param string $href
     */
    public function setHref(string $href): void
    {
        $this->href = $href;
    }

    public function checkUserPermission(Request $request) : CustomResponse
    {
        $this->prepareViewModelForCheckUserPermission($request);
        return $this->userInfoUseCase->checkUserPermission($this);
    }

    private function prepareViewModelForCheckUserPermission(Request $request)
    {
        $userInfoViewModel = $request->userInfoViewModel;

        if (is_string($request->userInfoViewModel)){
            $userInfoViewModel = json_decode($request->userInfoViewModel,true);
        }

        $this->setEmail($userInfoViewModel["email"]);
        $this->setSessionId($userInfoViewModel["sessionId"]);
        $this->setHref($userInfoViewModel["href"]);
        $this->setOperation($request->operation);
    }
}
