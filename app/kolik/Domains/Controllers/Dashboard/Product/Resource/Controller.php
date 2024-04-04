<?php

declare(strict_types=1);

namespace App\kolik\Domains\Controllers\Dashboard\Product\Resource;

use App\Http\Controllers\Controller as BaseController;
use App\kolik\Domains\Core\DTO\Dashboard\Product\Resource\IndexResponseDTO;
use App\kolik\Domains\Resource\Dashboard\Product\Resource\IndexResource;
use App\Models\CarModel;
use App\Models\Category;
use App\Models\Manufacturer;
use App\Models\ModelGeneration;
use Illuminate\Http\JsonResponse;

final class Controller extends BaseController
{
    /**
     * @OA\Get(
     *     summary="Get product resource",
     *     path="/dashboard/products/resources",
     *     operationId="dasdboard-product-resource-index",
     *     tags={"dashboard", "product", "resource"},
     *     description="Get resource like categories, manufacturer",
     *     parameters={},
     *
     *     @OA\Response(
     *          response=200,
     *          description="Product resource are successfully loaded.",
     *
     *          @OA\JsonContent(ref="#/components/schemas/DashboardProductIndexResource"),
     *     )
     * )
     */
    public function index(): JsonResponse
    {
        return $this->response(
            'Product resource are successfully loaded.',
            new IndexResource(new IndexResponseDTO(
                Category::all(),
                Manufacturer::all(),
                CarModel::all(),
                ModelGeneration::all(),
            ))
        );
    }
}
