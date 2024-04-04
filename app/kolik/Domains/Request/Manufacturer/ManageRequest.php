<?php

declare(strict_types=1);

namespace App\kolik\Domains\Request\Manufacturer;

use App\Http\Requests\Request as FormRequest;

/**
 * @OA\Schema(
 *     schema="ManufacturerManageRequest",
 *     required={"name"},
 *
 *      @OA\Property(
 *           property="name",
 *           type="string",
 *           example="Toyota"
 *      )
 * )
 */
final class ManageRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'name' => ['required', 'string'],
        ];
    }

    public function getName(): string
    {
        return $this->validated('name');
    }
}
