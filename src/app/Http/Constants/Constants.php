<?php

namespace Usermp\LaravelLogin\app\Http\Constants;

class Constants
{
    const SUCCESS = env("LARAVEL_LOGIN_SUCCESS", "Success");
    const SUCCESS_STORE = env("LARAVEL_LOGIN_SUCCESS_STORE", "Store Successful");
    const SUCCESS_UPDATE = env("LARAVEL_LOGIN_SUCCESS_UPDATE", "Update Successful");
    const SUCCESS_DELETE = env("LARAVEL_LOGIN_SUCCESS_DELETE", "Delete Successful");
    const ERROR = env("LARAVEL_LOGIN_ERROR", "Error");
    const ERROR_UPDATE = env("LARAVEL_LOGIN_ERROR_UPDATE", "Update Error");
    const ERROR_STORE = env("LARAVEL_LOGIN_ERROR_STORE", "Store Error");
    const ERROR_DELETE = env("LARAVEL_LOGIN_ERROR_DELETE", "Delete Error");

    const SUCCESS_LOGIN = env("LARAVEL_LOGIN_SUCCESS_LOGIN", "Login successful. Welcome to the system!");
    const ERROR_LOGIN = env("LARAVEL_LOGIN_ERROR_LOGIN", "Invalid credentials. The provided username or password does not match our records.");
    const EMAIL_DISABLE = env("LARAVEL_LOGIN_EMAIL_DISABLE", "Email login is disabled.");
    const OTP_EXPIRED = env("LARAVEL_LOGIN_OTP_EXPIRED", "The OTP has expired. Please request a new one.");
    const OTP_STILL_VALID = env("LARAVEL_LOGIN_OTP_STILL_VALID", "A valid OTP already exists. Please use the existing OTP or wait until it expires.");
}
