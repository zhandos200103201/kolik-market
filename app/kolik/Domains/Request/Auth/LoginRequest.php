<?php

declare(strict_types=1);

namespace App\kolik\Domains\Request\Auth;

use App\Http\Requests\Request as FormRequest;
use App\Models\User;
use Illuminate\Validation\Rules\Exists;

final class LoginRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'email' => ['required', 'string',  new Exists(User::class, 'email')],
            'password' => ['required', 'string', 'min:8'],
        ];
    }
}
