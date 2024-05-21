<?php

namespace Usermp\LaravelLogin\app\Http\Controllers\Auth;

use Illuminate\Support\Carbon;
use Illuminate\Http\JsonResponse;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Auth;
use Usermp\LaravelLogin\app\Models\Otp;
use Usermp\LaravelLogin\app\Models\User;
use Usermp\LaravelLogin\app\Http\Services\Response;
use Usermp\LaravelLogin\app\Http\Constants\Constants;
use Usermp\LaravelLogin\app\Http\Requests\Auth\SignupRequest;
use Usermp\LaravelLogin\app\Http\Requests\Auth\CredentialsRequest;

class SignupController extends Controller
{
    public function signup(SignupRequest $request)
    {
        $validated = $request->validated();

        $otpRecord = Otp::where('username', $validated['phone'])
            ->where('type', 'Login')
            ->latest('expired_at')
            ->first();

        $user = User::create([
            "phone"      => $validated['phone'],
            "name"       => $validated['first_name'],
            "lastname"   => $validated['last_name'],
            "password"   => $validated['password'],
            "email"      => $validated['email'],
        ]);

        $user['token'] = $user->createToken('Laravel Password Grant Client')->accessToken;
        return Response::success("", $user);
        
    }
}
