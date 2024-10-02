<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use App\Models\User;

class UserCreateRequest extends FormRequest
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
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        $user_type_option =  User::ADMIN_USER . ',' . User::STAFF_USER;

        return [
            'firstname' => ['required', 'string', 'max:100'],
            'lastname' => ['required', 'string', 'max:100'],
            'email' => ['required', 'string', 'email' /* or email:dns */, 'unique:users,email'],
            'name' => ['required', 'string', 'max:100', 'unique:users,name'],
            'password' => ['required', 'string', 'max:100'],
            'userType' => ['required', "in:$user_type_option"]
        ];
    }
}
