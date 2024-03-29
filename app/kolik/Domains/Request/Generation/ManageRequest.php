<?php

declare(strict_types=1);

namespace App\kolik\Domains\Request\Generation;

use App\Http\Requests\Request as BaseRequest;
use App\kolik\Domains\Core\DTO\Generation\CreateDTO;
use App\Models\CarModel;
use Illuminate\Validation\Rules\Exists;

/**
 * @OA\Schema(
 *     schema="GenerationManageRequest",
 *     required={"model_id", "start_year", "end_year"},
 *
 *      @OA\Property(
 *           property="model_id",
 *           type="integer",
 *           example="1"
 *      ),
 *      @OA\Property(
 *           property="start_year",
 *           type="string",
 *           example="2015"
 *      ),
 *      @OA\Property(
 *           property="end_year",
 *           type="string",
 *           example="2024"
 *      )
 * )
 */
final class ManageRequest extends BaseRequest
{
    public function rules(): array
    {
        return [
            'model_id' => ['required', 'integer', new Exists(CarModel::class, 'model_id')],
            'start_year' => ['required', 'integer'],
            'end_year' => ['required', 'integer'],
        ];
    }

    public function getDto(): CreateDTO
    {
        return new CreateDTO(
            (int) $this->validated('model_id'),
            (int) $this->validated('start_year'),
            (int) $this->validated('end_year'),
        );
    }
}
