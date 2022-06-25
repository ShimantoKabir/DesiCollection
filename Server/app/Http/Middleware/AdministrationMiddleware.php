<?php

namespace App\Http\Middleware;

use App\Enums\CustomResponseCode;
use App\Enums\CustomResponseMsg;
use App\Enums\HttpRequestType;
use App\Enums\OperationType;
use App\ViewModels\UserInfoViewModel;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class AdministrationMiddleware
{
    public UserInfoViewModel $userInfoViewModel;

    public function __construct(UserInfoViewModel $userInfoViewModel)
    {
        $this->userInfoViewModel = $userInfoViewModel;
    }

    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {
        $authResponse = $this->checkAuthInput($request);

        if($authResponse == CustomResponseMsg::OK->value){
            $request->merge([
                'operation' => $this->getOperationByHttpRequestType($request)
            ]);

            $permissionResponse = $this->userInfoViewModel->checkUserPermission($request);

            if ($permissionResponse->getCode() == CustomResponseCode::SUCCESS->value){
                $request->merge([
                    'modifiedBy' => $permissionResponse->getModel()->id,
                ]);
                return $next($request);
            }else{
                return response([
                    "msg" => $permissionResponse->getMsg(),
                    "code" => $permissionResponse->getCode()
                ]);
            }
        }else{
            return response([
                "msg" => $authResponse,
                "code" => CustomResponseCode::ERROR->value
            ]);
        }
    }

    private function getOperationByHttpRequestType(Request $request): string
    {
        if ($request->isMethod(HttpRequestType::POST->value)){
            return OperationType::CREATE->value;
        }else if ($request->isMethod(HttpRequestType::DELETE->value)){
            return OperationType::DELETE->value;
        }else if ($request->isMethod(HttpRequestType::PUT->value)){
            return OperationType::UPDATE->value;
        }else{
            return OperationType::READ->value;
        }
    }

    private function checkAuthInput(Request $request) : string
    {
        $authMsg = CustomResponseMsg::OK->value;

        $userInfoViewModel = $request->userInfoViewModel;

        if (is_string($request->userInfoViewModel)){
            $userInfoViewModel = json_decode($request->userInfoViewModel,true);
        }

        $validator = Validator::make($userInfoViewModel,[
            'email' => 'required|email',
            'href' => 'required|string',
            'sessionId' => 'required|string'
        ]);

        if($validator->fails()){
            $authMsg = $validator->errors()->first();
        }

        return $authMsg;
    }

}
