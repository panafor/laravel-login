<?php

namespace Usermp\LaravelLogin\app\Http\Constants;

class Constants
{
    const SUCCESS = "Success";
    const SUCCESS_STORE = "Store Successful";
    const SUCCESS_UPDATE = "Update Successful";
    const SUCCESS_DELETE = "Delete Successful";
    const ERROR = "Error";
    const ERROR_UPDATE = "Update Error";
    const ERROR_STORE = "Store Error";
    const ERROR_DELETE = "Delete Error";

    const SUCCESS_LOGIN = env("LARAVEL_LOGIN_SUCCESS_LOGIN","Login successful. Welcome to the system!");
    const ERROR_LOGIN   = "Invalid credentials. The provided username or password does not match our records.";
    const EMAIL_DISABLE = 'Email login is disabled.';
    const OTP_EXPIRED = 'The OTP has expired. Please request a new one.';
    const OTP_STILL_VALID = 'A valid OTP already exists. Please use the existing OTP or wait until it expires.';
}
