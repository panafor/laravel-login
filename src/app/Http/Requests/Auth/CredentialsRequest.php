<?php

namespace Usermp\LaravelLogin\app\Http\Requests\Auth;

use Usermp\LaravelLogin\app\Rules\Username;
use Illuminate\Contracts\Validation\ValidationRule;
use Usermp\LaravelLogin\app\Http\Requests\BaseRequest;

class CredentialsRequest extends BaseRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, ValidationRule|array|string>
     */
    public function rules(): array
    {
        return [
            "username"    => ['required', new Username],
            "credentials" => "required|string",
            "type"        => "required|string|in:password,otp",
        ];
    }
}