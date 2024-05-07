<?php

declare(strict_types=1);

namespace App\kolik\Domains\Request\Feedback;

use App\Http\Requests\Request as FormRequest;
use App\kolik\Domains\Core\DTO\Feedback\CreateDTO;
use App\Models\Product;
use App\Models\Service;
use Illuminate\Validation\Rules\Exists;

/**
 * @OA\Schema(
 *     schema="FeedbackCreateRequest",
 *     required={"content", "score"},
 *     description="You should send me either product_id, or service_id",
 *
 *      @OA\Property(
 *           property="product_id",
 *           type="integer",
 *           example="1"
 *      ),
 *      @OA\Property(
 *           property="service_id",
 *           type="integer",
 *           example="2"
 *      ),
 *      @OA\Property(
 *           property="content",
 *           type="string",
 *           example="This service is very good."
 *      ),
 *      @OA\Property(
 *           property="score",
 *           type="float",
 *           example="4.5"
 *      ),
 *      @OA\Property(
 *           property="name",
 *           type="string",
 *           example="Zhandos"
 *      )
 * )
 */
final class CreateRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'product_id' => ['required_without:service_id', 'integer', new Exists(Product::class, 'product_id')],
            'service_id' => ['required_without:product_id', 'integer', new Exists(Service::class, 'service_id')],
            'content' => ['required', 'string'],
            'score' => ['required', 'numeric', 'between:0,5'],
            'name' => ['required', 'string'],
        ];
    }

    public function getDto(): CreateDTO
    {
        $productId = $this->validated('product_id');
        $serviceId = $this->validated('service_id');

        return new CreateDTO(
            $productId !== null ? (int) $productId : null,
            $serviceId !== null ? (int) $serviceId : null,
            $this->validated('content'),
            (float) $this->validated('score'),
            $this->validated('name'),
        );
    }
}
