<?php

declare(strict_types=1);

namespace App\kolik\Domains\Request\Auth\Password;

use App\Http\Requests\Request as FormRequest;
use App\Models\User;
use Illuminate\Validation\Rules\Exists;

final class ResetRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'email' => ['required', 'email', new Exists(User::class, 'email')],
            'password' => ['required', 'confirmed', 'min:8'],
        ];
    }

    public function getEmail(): string
    {
        return $this->validated('email');
    }

    public function getPassword(): string
    {
        return $this->validated('password');
    }
}
