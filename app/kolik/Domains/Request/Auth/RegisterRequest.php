<?php

declare(strict_types=1);

namespace App\kolik\Domains\Request\Auth;

use App\Http\Requests\Request as FormRequest;
use App\kolik\Domains\Core\DTO\Auth\Register\RequestDTO;
use App\Models\User;
use Illuminate\Validation\Rule;

final class RegisterRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'name' => ['required', 'string', 'min:5'],
            'email' => ['required', 'email', Rule::unique(User::class, 'email')],
            'phone' => ['required', 'string', 'min:11'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
        ];
    }

    public function getDto(): RequestDTO
    {
        return new RequestDTO(
            $this->validated('name'),
            $this->validated('email'),
            $this->validated('phone'),
            $this->validated('password')
        );
    }
}
