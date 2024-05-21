<?php

namespace Usermp\LaravelLogin\app\Http\Requests\Auth;

use Usermp\LaravelLogin\app\Rules\Username;
use Illuminate\Contracts\Validation\ValidationRule;
use Usermp\LaravelLogin\app\Http\Requests\BaseRequest;

class SignupRequest extends BaseRequest
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
            "phone"      => ['required', new Username, 'unique:users,phone'],
            "first_name" => ['required', 'string', 'max:255'],
            "last_name"  => ['required', 'string', 'max:255'],
            "email"      => ['required', 'nullable', 'email'],
        ];
    }
}
