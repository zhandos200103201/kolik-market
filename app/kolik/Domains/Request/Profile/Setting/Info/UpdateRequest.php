<?php

declare(strict_types=1);

namespace App\kolik\Domains\Request\Profile\Setting\Info;

use App\Http\Requests\Request as FormRequest;
use App\kolik\Domains\Core\DTO\Profile\Setting\Info\UpdateDTO;
use App\Models\User;
use Illuminate\Validation\Rule;

/**
 * @OA\Schema(
 *     schema="ProfileSettingInfoUpdateRequest",
 *     required={"name", "email", "address", "photo"},
 *
 *      @OA\Property(
 *           property="name",
 *           type="string",
 *           example="Zhandos"
 *      ),
 *      @OA\Property(
 *           property="email",
 *           type="string",
 *           example="zhandos@gmail.com"
 *      ),
 *      @OA\Property(
 *           property="address",
 *           type="string",
 *           example="Almaty"
 *      ),
 *      @OA\Property(
 *           property="photo",
 *           type="string",
 *           example="base64 format image"
 *      )
 * )
 */
final class UpdateRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'name' => ['required', 'string'],
            'email' => ['required', 'email'],
            'address' => ['required', 'string', Rule::unique(User::class, 'email')],
            'photo' => ['required', 'string'],
        ];
    }

    public function getDto(): UpdateDTO
    {
        return new UpdateDTO(
            $this->validated('name'),
            $this->validated('email'),
            $this->validated('address'),
            $this->validated('photo'),
        );
    }
}
