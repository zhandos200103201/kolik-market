<?php

declare(strict_types=1);

namespace App\kolik\Domains\Request\Profile\Product;

use App\Http\Requests\Request as FormRequest;
use App\kolik\Domains\Core\DTO\Profile\Product\CreateDTO;
use App\Models\CarModel;
use App\Models\Category;
use App\Models\Manufacturer;
use App\Models\Product;
use Illuminate\Validation\Rules\Exists;

/**
 * @OA\Schema(
 *     schema="ProfileProductManageRequest",
 *     required={"category_id", "product_name", "description", "photo", "price", "is_used", "views"},
 *
 *      @OA\Property(
 *           property="category_id",
 *           type="integer",
 *           example="1"
 *      ),
 *      @OA\Property(
 *           property="product_name",
 *           type="string",
 *           example="Triapka"
 *      ),
 *      @OA\Property(
 *           property="description",
 *           type="string",
 *           example="Product washing the car"
 *      ),
 *      @OA\Property(
 *           property="photo",
 *           type="string",
 *           example="base64 format image"
 *      ),
 *      @OA\Property(
 *           property="price",
 *           type="integer",
 *           example="18000"
 *      ),
 *      @OA\Property(
 *           property="count",
 *           type="integer",
 *           example="231"
 *      ),
 *      @OA\Property(
 *           property="is_used",
 *           type="boolean",
 *           example="true"
 *      ),
 *      @OA\Property(
 *           property="views",
 *           type="integer",
 *           example="user views"
 *      )
 * )
 */
final class ManageRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'category_id' => ['required', 'integer', new Exists(Category::class, 'category_id')],
            'product_name' => ['required', 'string'],
            'description' => ['required', 'string'],
            'photo' => ['required', 'string'],
            'price' => ['required', 'integer'],
            'is_used' => ['required', 'boolean'],
            'count' => ['nullable', 'integer'],
            'manufacturer_id' => ['nullable', 'integer', new Exists(Manufacturer::class, 'manufacturer_id')],
            'model_id' => ['nullable', 'integer', new Exists(CarModel::class, 'model_id')],
        ];
    }

    public function getDto(): CreateDTO
    {
        $count = $this->validated('count');

        return new CreateDTO(
            $this->validated('product_name'),
            $this->validated('description'),
            $this->validated('photo'),
            (int) $this->validated('price'),
            $count !== null ? (int) $count : null,
            (bool) $this->validated('is_used'),
            (int) $this->validated('category_id'),
            (int) $this->validated('manufacturer_id'),
            (int) $this->validated('model_id'),
        );
    }
}
