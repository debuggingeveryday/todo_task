<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use App\Models\User;
use Illuminate\Http\Request;

class UserUpdateRequest extends FormRequest
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
        $request = Request::only('id');

        $user_type_option =  User::ADMIN_USER . ',' . User::STAFF_USER;

        return [
            'id' => ['exists:users,id'],
            'firstname' => ['required', 'string', 'max:100'],
            'lastname' => ['required', 'string', 'max:100'],
            'email' => ['required', 'string', 'email' /* or email:dns */, 'unique:users,email,' . $request['id']],
            'name' => ['required', 'string', 'max:100', 'unique:users,name,' . $request['id']],
            'password' => ['nullable', 'string', 'max:100'],
            'userType' => ['required', "in:$user_type_option"]
        ];
    }
}
