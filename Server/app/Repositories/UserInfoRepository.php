<?php

namespace App\Repositories;

use App\Enums\CustomResponseCode;
use App\Enums\CustomResponseMsg;
use App\Models\CustomResponse;
use App\Models\UserInfo;
use App\Repositories\Interfaces\IUserInfoRepository;
use App\ViewModels\UserInfoViewModel;
use Exception;
use Illuminate\Http\Request;

class UserInfoRepository extends BaseRepository implements IUserInfoRepository
{

    /**
     * @return array
     */
    public function read(): array
    {
        return [];
    }

    /**
     * @param UserInfoViewModel $userInfoViewModel
     * @return CustomResponse
     */
    public function checkUserPermission(UserInfoViewModel $userInfoViewModel): CustomResponse
    {
        $response = new CustomResponse();

        try{

            $userInfos = UserInfo::where('email', $userInfoViewModel->getEmail())
                ->where('session_id',$userInfoViewModel->getSessionId())
                ->get();

            if (count($userInfos) > 0) {

                $u = $userInfos[0];
                $opAccess = $u->op_access;
                $roleOid = $u->role_oid;
                $sessionId = $u->session_id;

                $menuRequest = new Request([
                    'userInfo' => [
                        "roleOid" => $roleOid,
                        "sessionId" => $sessionId,
                        "email" => $userInfoViewModel->getEmail(),
                        "path" => $userInfoViewModel->getHref()
                    ],
                ]);

                $menus = MenuRpo::getAuthorizedMenusByUserInfo($menuRequest);
                $paths = $menus['paths'];

                if (in_array($userInfoViewModel->getHref(), (array) $paths))
                {
                    if (str_contains($opAccess, $userInfoViewModel->getOperation())) {
                        $response->setMsg(CustomResponseMsg::PERMISSION_OK->value);
                        $response->setCode(CustomResponseCode::SUCCESS->value);
                        $response->setModel($u);
                    } else {
                        $response->setMsg(CustomResponseMsg::PAGE_PERMISSION_DENIED->value);
                        $response->setCode(CustomResponseCode::ERROR->value);
                    }
                }
                else
                {
                    $response->setMsg(CustomResponseMsg::PAGE_PERMISSION_DENIED->value);
                    $response->setCode(CustomResponseCode::ERROR->value);
                }
            }else{
                $response->setMsg(CustomResponseMsg::SESSION_EXPIRED->value);
                $response->setCode(CustomResponseCode::ERROR->value);
            }

        }catch (Exception $e){
            $response->setMsg($e->getMessage());
            $response->setCode(CustomResponseCode::ERROR->value);
        }
        return $response;
    }
}
