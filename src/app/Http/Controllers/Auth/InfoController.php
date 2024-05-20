<?php

namespace Usermp\LaravelLogin\app\Http\Controllers\Auth;


use Illuminate\Routing\Controller;
use Usermp\LaravelLogin\app\Http\Services\Response;
use Usermp\LaravelLogin\app\Http\Constants\Constants;

class InfoController extends Controller
{
    public function info()
    {
        if (auth()->user())
            return Response::success(Constants::SUCCESS,auth()->user());

        return Response::error(Constants::ERROR,400);
    }
}
