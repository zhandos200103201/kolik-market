<?php

declare(strict_types=1);

namespace App\kolik\Domains\Request\Auth\Password;

use App\Http\Requests\Request as FormRequest;
use App\Models\User;
use Illuminate\Validation\Rules\Exists;

final class ResetLinkRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'email' => ['required', 'email', new Exists(User::class, 'email')],
        ];
    }

    public function getEmail(): string
    {
        return $this->validated('email');
    }
}
