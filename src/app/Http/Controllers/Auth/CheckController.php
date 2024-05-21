<?php

namespace Usermp\LaravelLogin\app\Http\Controllers\Auth;

use Illuminate\Routing\Controller;
use Carbon\Carbon;
use Usermp\LaravelLogin\app\Models\Otp;
use Usermp\LaravelLogin\app\Models\User;
use Usermp\LaravelLogin\Jobs\SendSmsToken;
use Usermp\LaravelLogin\app\Http\Services\Helpers;
use Usermp\LaravelLogin\app\Http\Services\Response;
use Usermp\LaravelLogin\app\Http\Constants\Constants;
use Usermp\LaravelLogin\app\Http\Requests\Auth\LoginCheckRequest;

class CheckController extends Controller
{
    /**
     * Handles the login check process.
     *
     * @param LoginCheckRequest $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function check(LoginCheckRequest $request): \Illuminate\Http\JsonResponse
    {
        $validated = $request->validated();
        $username = $validated['username'];

        if ($this->isEmail($username)) {
            return Response::error(Constants::EMAIL_DISABLE, 500);
        }

        if ($this->requiresOtp($validated)) {
            return $this->processOtp($username);
        }

        return $this->processLogin($username);
    }

    /**
     * Checks if the provided username is an email.
     *
     * @param string $username
     * @return bool
     */
    private function isEmail(string $username): bool
    {
        return filter_var($username, FILTER_VALIDATE_EMAIL) !== false;
    }

    /**
     * Determines if OTP is required based on the validated data.
     *
     * @param array $validated
     * @return bool
     */
    private function requiresOtp(array $validated): bool
    {
        return !empty($validated['otp']);
    }

    /**
     * Processes the OTP flow.
     *
     * @param string $username
     * @return \Illuminate\Http\JsonResponse
     */
    private function processOtp(string $username): \Illuminate\Http\JsonResponse
    {
        if (!$this->isOtpExpired($username)) {
            return Response::error(Constants::OTP_STILL_VALID, 400);
        }

        $otp = $this->generateAndSendOtp($username);
        $this->storeOtp($username, $otp);

        return $this->generateOtpResponse($username);
    }

    /**
     * Processes the login flow.
     *
     * @param string $username
     * @return \Illuminate\Http\JsonResponse
     */
    private function processLogin(string $username): \Illuminate\Http\JsonResponse
    {
        $user = User::where('phone', $username)->first();

        if (!$user || !$user->password) {
            return $this->processOtp($username);
        }

        if (!$user || $this->isOtpExpired($username)) {
            return $this->processOtp($username);
        }

        return $this->generateLoginResponse($username);
    }

    /**
     * Generates the OTP response.
     *
     * @param string $username
     * @return \Illuminate\Http\JsonResponse
     */
    private function generateOtpResponse(string $username): \Illuminate\Http\JsonResponse
    {
        return Response::success(Constants::SUCCESS, [
            'method'   => $this->getOtpMethod($username),
            'username' => $username,
            'otp_ttl'  => env('OTP_TOKEN_EXPIRE_SECONDS', 180),
        ]);
    }

    /**
     * Determines the OTP method based on the username.
     *
     * @param string $username
     * @return string
     */
    private function getOtpMethod(string $username): string
    {
        return User::where('phone', $username)->exists() ? 'otp' : 'register';
    }

    /**
     * Generates the login response.
     *
     * @param string $username
     * @return \Illuminate\Http\JsonResponse
     */
    private function generateLoginResponse(string $username): \Illuminate\Http\JsonResponse
    {
        return Response::success(Constants::SUCCESS, [
            'method'   => 'password',
            'username' => $username,
            'otp_ttl'  => 0,
        ]);
    }

    /**
     * Generates and sends OTP.
     *
     * @param string $username
     * @return string
     */
    private function generateAndSendOtp(string $username): string
    {
        $otp = Helpers::otp(env('OTP_TOKEN_NUM_DIGITS', 6));
        SendSmsToken::dispatch($username, $otp);
        return $otp;
    }

    /**
     * Stores the generated OTP.
     *
     * @param string $username
     * @param string $otp
     * @return void
     */
    private function storeOtp(string $username, string $otp): void
    {
        Otp::create([
            'username'   => $username,
            'token'      => $otp,
            'type'       => 'Login',
            'expired_at' => Carbon::now()->addSeconds(env('OTP_TOKEN_EXPIRE_SECONDS', 180)),
        ]);
    }

    /**
     * Checks if the OTP is expired for the given username.
     *
     * @param string $username
     * @return bool
     */
    private function isOtpExpired(string $username): bool
    {
        $otpRecord = Otp::where('username', $username)
                        ->where('type', 'Login')
                        ->latest('expired_at')
                        ->first();

        return $otpRecord ? Carbon::now()->greaterThan($otpRecord->expired_at) : true;
    }
}
