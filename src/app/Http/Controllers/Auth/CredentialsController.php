<?php

namespace Usermp\LaravelLogin\app\Http\Controllers\Auth;

use Illuminate\Http\JsonResponse;
use Illuminate\Support\Carbon;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Auth;
use Usermp\LaravelLogin\app\Models\Otp;
use Usermp\LaravelLogin\app\Models\User;
use Usermp\LaravelLogin\app\Http\Services\Response;
use Usermp\LaravelLogin\app\Http\Constants\Constants;
use Usermp\LaravelLogin\app\Http\Requests\Auth\CredentialsRequest;

class CredentialsController extends Controller
{
    /**
     * Handle the incoming credential request.
     *
     * This method handles the authentication request based on the type
     * specified in the request. It can either authenticate using OTP or password.
     *
     * @param CredentialsRequest $request
     * @return JsonResponse
     */
    public function credential(CredentialsRequest $request): JsonResponse
    {
        $validated = $request->validated();

        if ($validated['type'] === 'otp') {
            return $this->handleWithOtp($validated);
        }

        return $this->handleWithPassword($validated);
    }

    /**
     * Handle authentication using OTP.
     *
     * This method verifies the OTP provided in the request. If the OTP is valid and not expired,
     * it retrieves the user associated with the OTP and returns a success response with an access token.
     *
     * @param array $validated
     * @return JsonResponse
     */
    private function handleWithOtp(array $validated): JsonResponse
    {
        $otpRecord = Otp::where('username', $validated['username'])
                        ->where('type', 'Login')
                        ->latest('expired_at')
                        ->first();

        if (!$otpRecord || Carbon::now()->greaterThan($otpRecord->expired_at)) {
            return Response::error(Constants::OTP_EXPIRED);
        }

        if ($otpRecord->token !== $validated['credentials']) {
            return Response::error(Constants::ERROR_LOGIN_OTP);
        }

        $user = User::where('phone', $otpRecord->username)->first();
        if (!$user) {
            return Response::error(Constants::ERROR_REGISTER_FIRST, 500,"Register");
        }

        $user['token'] = $user->createToken('Laravel Password Grant Client')->accessToken;
        return Response::success("", $user);
    }

    /**
     * Handle authentication using password.
     *
     * This method verifies the password provided in the request. If the credentials are valid,
     * it retrieves the user and returns a success response with an access token.
     *
     * @param array $validated
     * @return JsonResponse
     */
    private function handleWithPassword(array $validated): JsonResponse
    {
        $credentials = [
            'phone' => $validated['username'],
            'password' => $validated['credentials'],
        ];

        if (!Auth::attempt($credentials)) {
            return Response::error(Constants::ERROR_LOGIN, 401);
        }

        $user = User::where('phone', $validated['username'])->first();
        if (!$user) {
            return Response::error(Constants::ERROR_LOGIN, 401);
        }

        $user['token'] = $user->createToken('Laravel Password Grant Client')->accessToken;
        return Response::success("", $user);
    }
}
