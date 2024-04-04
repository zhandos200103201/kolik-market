<?php

declare(strict_types=1);

namespace App\kolik\Domains\Request\City;

use App\Http\Requests\Request as FormRequest;

/**
 * @OA\Schema(
 *     schema="CityManageRequest",
 *     required={"city"},
 *
 *      @OA\Property(
 *           property="city",
 *           type="string",
 *           example="Almaty"
 *      )
 * )
 */
final class ManageRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'city' => ['required', 'string'],
        ];
    }

    public function getCity(): string
    {
        return $this->validated('city');
    }
}
