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
        
    }
}