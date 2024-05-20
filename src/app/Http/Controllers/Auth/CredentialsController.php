<?php

namespace Usermp\LaravelLogin\app\Http\Controllers\Auth;


use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Auth;
use Usermp\LaravelLogin\app\Models\User;
use Usermp\LaravelLogin\app\Http\Services\Response;
use Usermp\LaravelLogin\app\Http\Constants\Constants;
use Usermp\LaravelLogin\app\Http\Requests\Auth\CredentialsRequest;

class CredentialsController extends Controller
{
    public function credential(CredentialsRequest $request)
    {
        $validated = $request->validated();

        if($validated['type'] == "otp")
        {
            return $this->handleWithOtp($validated);
        }

        return $this->handleWithPassword($validated);
    }

    private function handleWithOtp(array $validated)
    {

    }
    private function handleWithPassword(array $validated)
    {
        $username = $validated['username'];
        $user = User::where("phone", $username)->first();

        if( ! $user )
            return Response::error(Constants::ERROR_LOGIN,401);

        $credential = [
            "phone"    => $validated['username'],
            "password" => $validated['credentials'],
        ];
        if (Auth::attempt($credential))
        {
            $user['token'] = $user->createToken('Laravel Password Grant Client')->accessToken;
            return Response::success("",$user);
        }
        return Response::error(Constants::ERROR_LOGIN);
    }
}
