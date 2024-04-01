<?php

declare(strict_types=1);

namespace App\kolik\Domains\Request\Model;

use App\Http\Requests\Request as FormRequest;
use App\kolik\Domains\Core\DTO\Model\ManageDTO;
use App\Models\CarModel;
use App\Models\Manufacturer;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Rules\Exists;

/**
 * @OA\Schema(
 *     schema="ModelManageRequest",
 *     required={"model_name", "manufacturer_id"},
 *
 *      @OA\Property(
 *           property="model_name",
 *           type="string",
 *           example="Camry"
 *      ),
 *      @OA\Property(
 *           property="manufacturer_id",
 *           type="integer",
 *           example="1"
 *      )
 * )
 */
final class ManageRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'model_name' => ['required', 'string', Rule::unique(CarModel::class, 'model_name')],
            'manufacturer_id' => ['required', 'integer', new Exists(Manufacturer::class, 'manufacturer_id')],
        ];
    }

    public function getDto(): ManageDTO
    {
        return new ManageDTO(
            $this->validated('model_name'),
            (int) $this->validated('manufacturer_id')
        );
    }
}
