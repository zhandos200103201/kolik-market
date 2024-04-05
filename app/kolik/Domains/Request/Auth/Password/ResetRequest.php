<?php

declare(strict_types=1);

namespace App\kolik\Domains\Request\Auth\Password;

use App\Http\Requests\Request as FormRequest;
use App\kolik\Domains\Core\DTO\Profile\Setting\Password\ResetRequestDTO;
use App\Models\User;
use Illuminate\Validation\Rules\Exists;

/**
 * @OA\Schema(
 *     schema="ProfileSettingPasswordResetRequest",
 *     required={"city"},
 *
 *      @OA\Property(
 *           property="email",
 *           type="email",
 *           example="test@test.com"
 *      ),
 *      @OA\Property(
 *           property="current_password",
 *           type="string",
 *           example="112341234"
 *      ),
 *      @OA\Property(
 *           property="new_password",
 *           type="string",
 *           example="12341234"
 *      ),
 *      @OA\Property(
 *           property="new_password_confirmation",
 *           type="string",
 *           example="1234234"
 *      )
 * )
 */
final class ResetRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'email' => ['required', 'email', new Exists(User::class, 'email')],
            'current_password' => ['required', 'min:8'],
            'new_password' => ['required', 'confirmed', 'min:8'],
        ];
    }

    public function getDto(): ResetRequestDTO
    {
        return new ResetRequestDTO(
            $this->validated('email'),
            $this->validated('current_password'),
            $this->validated('new_password')
        );
    }
}
