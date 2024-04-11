<?php

declare(strict_types=1);

namespace App\kolik\Domains\Controllers\Dashboard\Product;

use App\Http\Controllers\Controller as BaseController;
use App\kolik\Domains\Core\Handlers\Dashboard\Product\IndexHandler;
use App\kolik\Domains\Request\Dashboard\Product\IndexRequest;
use App\kolik\Domains\Resource\Profile\Product\IndexResource;
use App\Models\Product;
use Illuminate\Http\JsonResponse;

final class Controller extends BaseController
{
    /**
     * @OA\Get(
     *     summary="Get products.",
     *     path="/dashboard/products",
     *     operationId="dashboard-product-index",
     *     tags={"dashboard", "product"},
     *     description="Getting products by parameters.",
     *     parameters={
     *       {"name": "category_id", "in":"query", "type":"integer", "required":true, "description":"id of category"},
     *       {"name": "manufacturer_id", "in":"query", "type":"integer", "required":true, "description":"id of manufacturer"},
     *       {"name": "car_model_id", "in":"query", "type":"integer", "required":true, "description":"id of car model"},
     *       {"name": "generation_id", "in":"query", "type":"integer", "required":true, "description":"id of generation"},
     *       {"name": "name", "in":"query", "type":"string", "required":true, "description":"Name of product"},
     *      },
     *
     *     @OA\RequestBody(
     *
     *          @OA\MediaType(
     *              mediaType="application/json",
     *
     *              @OA\Schema(ref="#/components/schemas/DashboardProductIndexRequest")
     *          )
     *      ),
     *
     *     @OA\Response(
     *          response=200,
     *          description="Products are successfully retrieved.",
     *
     *          @OA\JsonContent(ref="#/components/schemas/ProfileProductIndexResource"),
     *     )
     * )
     */
    public function index(IndexRequest $request, IndexHandler $handler): JsonResponse
    {
        return $this->response(
            'Products are successfully retrieved.',
            IndexResource::collection($handler->handle($request->getDto()))
        );
    }

    /**
     * @OA\Get(
     *     summary="Get the product with feedbacks.",
     *     path="/dashboard/products/{product}",
     *     operationId="dashboard-product-show",
     *     tags={"dashboard", "product"},
     *     description="Getting the product with feedbacks.",
     *     parameters={},
     *
     *     @OA\Response(
     *          response=200,
     *          description="Product is successfully retrieved.",
     *
     *          @OA\JsonContent(ref="#/components/schemas/ProfileProductIndexResource"),
     *     )
     * )
     */
    public function show(Product $product): JsonResponse
    {
        $product->views += 1;
        $product->save();

        return $this->response(
            'Product is successfully retrieved.',
            new IndexResource($product->load('feedbacks'))
        );
    }
}
