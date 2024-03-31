<?php

declare(strict_types=1);

namespace App\kolik\Domains\Request\Category;

use App\Http\Requests\Request as FormRequest;
use App\kolik\Domains\Core\DTO\Category\ManageDTO;

/**
 * @OA\Schema(
 *     schema="CategoryManageRequest",
 *     required={"name", "description"},
 *
 *      @OA\Property(
 *           property="name",
 *           type="string",
 *           example="Name of category"
 *      ),
 *      @OA\Property(
 *           property="description",
 *           type="string",
 *           example="Description of category"
 *      )
 * )
 */
final class ManageRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'name' => ['required', 'string'],
            'description' => ['required', 'string'],
        ];
    }

    public function getDto(): ManageDTO
    {
        return new ManageDTO(
            $this->validated('name'),
            $this->validated('description')
        );
    }
}
