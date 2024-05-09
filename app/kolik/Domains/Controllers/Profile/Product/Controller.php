<?php

declare(strict_types=1);

namespace App\kolik\Domains\Controllers\Profile\Product;

use App\Http\Controllers\Controller as BaseController;
use App\kolik\Domains\Request\Profile\Product\ManageRequest;
use App\kolik\Domains\Resource\Profile\Product\IndexResource;
use App\kolik\Support\Core\Exceptions\DomainException;
use App\Models\Product;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;

final class Controller extends BaseController
{
    /**
     * @OA\Get (
     *     summary="Get user profile products",
     *     path="/profiles/products",
     *     operationId="profile-product-index",
     *     tags={"profile", "product"},
     *     description="Get user products.",
     *     parameters={
     *      {"name": "Authorization", "in":"header", "type":"string", "required":true, "description":"Bearer token"},
     *     },
     *
     *     @OA\Response(
     *          response=200,
     *          description="User products are successfully retrieved.",
     *
     *          @OA\JsonContent(ref="#/components/schemas/ProfileProductIndexResource"),
     *     )
     * )
     */
    public function index(): JsonResponse
    {
        /** @var User $user */
        $user = Auth::user();

        $userProducts = Product::query()
            ->with([
                'user',
                'category',
            ])
            ->where('user_id', $user->user_id)
            ->get();

        return $this->response(
            'User products are successfully retrieved.',
            IndexResource::collection($userProducts)
        );
    }

    /**
     * @OA\Get (
     *     summary="Get user profile product",
     *     path="/profiles/products/{product}",
     *     operationId="profile-product-show",
     *     tags={"profile", "product"},
     *     description="Get user product.",
     *     parameters={
     *      {"name": "Authorization", "in":"header", "type":"string", "required":true, "description":"Bearer token"},
     *     },
     *
     *     @OA\Response(
     *          response=200,
     *          description="User products are successfully retrieved",
     *
     *          @OA\JsonContent(ref="#/components/schemas/ProfileProductIndexResource"),
     *     )
     * )
     */
    public function show(Product $product): JsonResponse
    {
        return $this->response(
            'The user product is successfully retrieved.',
            $product
        );
    }

    /**
     * @OA\Post(
     *     summary="Create new user product.",
     *     path="/profiles/products",
     *     operationId="profile-product-create",
     *     tags={"profile", "product"},
     *     description="Create a new product",
     *     parameters={
     *      {"name": "Authorization", "in":"header", "type":"string", "required":true, "description":"Bearer token"},
     *      {"name": "category_id", "in":"query", "type":"string", "required":true, "description":"User name"},
     *      {"name": "product_name", "in":"query", "type":"string", "required":true, "description":"Product name"},
     *      {"name": "description", "in":"query", "type":"string", "required":true, "description":"Product description"},
     *      {"name": "photo", "in":"query", "type":"string", "required":true, "description":"Photo base64"},
     *      {"name": "price", "in":"query", "type":"integer", "required":true, "description":"Price of product"},
     *      {"name": "is_used", "in":"query", "type":"boolean", "required":true, "description":"Product used before"},
     *      {"name": "count", "in":"query", "type":"integer", "required":false, "description":"Sum of products"},
     *     },
     *
     *     @OA\RequestBody(
     *
     *         @OA\MediaType(
     *             mediaType="application/json",
     *
     *             @OA\Schema(ref="#/components/schemas/ProfileProductManageRequest")
     *         )
     *     ),
     *
     *     @OA\Response(
     *          response=200,
     *          description="Product is successfully created.",
     *     )
     * )
     */
    public function create(ManageRequest $request): JsonResponse
    {
        $userId = $request->getCurrentUser()->user_id;

        $dto = $request->getDto();

        Product::query()->insert([
            'name' => $dto->name,
            'description' => $dto->description,
            'photo' => $dto->photo,
            'price' => $dto->price,
            'count' => $dto->count,
            'is_used' => $dto->isUsed,
            'category_id' => $dto->category_id,
            'user_id' => $userId,
            'model_id' => $dto->model_id,
            'manufacturer_id' => $dto->manufacturer_id,
        ]);

        return $this->response(
            'New user product is successfully created.',
        );
    }

    /**
     * @OA\Put(
     *     summary="Set user product",
     *     path="/profiles/products",
     *     operationId="profile-product-update",
     *     tags={"profile", "product"},
     *     description="Update user product.",
     *     parameters={
     *      {"name": "Authorization", "in":"header", "type":"string", "required":true, "description":"Bearer token"},
     *      {"name": "product", "in":"query", "type":"integer", "required":true, "description":"Product id"},
     *     },
     *
     *     @OA\RequestBody(
     *
     *         @OA\MediaType(
     *             mediaType="application/json",
     *
     *             @OA\Schema(ref="#/components/schemas/ProfileProductManageRequest")
     *         )
     *     ),
     *
     *     @OA\Response(
     *          response=200,
     *          description="Product is successfully update.",
     *     )
     * )
     *
     * @throws DomainException
     */
    public function update(Product $product, ManageRequest $request): JsonResponse
    {
        $userId = $request->getCurrentUser()->user_id;

        if ($product->user_id !== $userId) {
            throw new DomainException('You do not have own permission.');
        }

        $dto = $request->getDto();

        $product->name = $dto->name;
        $product->description = $dto->description;
        $product->photo = $dto->photo;
        $product->price = $dto->price;
        $product->count = $dto->count;
        $product->is_used = $dto->isUsed;
        $product->category_id = $dto->category_id;
        $product->user_id = $userId;
        $product->model_id = $dto->model_id;
        $product->manufacturer_id = $dto->manufacturer_id;
        $product->save();

        return $this->response(
            'Product is successfully updated.',
        );
    }

    /**
     * @OA\Delete(
     *     summary="Delete user product",
     *     path="/profiles/products",
     *     operationId="profile-product-delete",
     *     tags={"profile", "product"},
     *     description="Delete user product.",
     *     parameters={
     *      {"name": "Authorization", "in":"header", "type":"string", "required":true, "description":"Bearer token"},
     *      {"name": "product", "in":"query", "type":"integer", "required":true, "description":"User product ID"},
     *     },
     *
     *     @OA\Response(
     *          response=200,
     *          description="Product is successfully deleted.",
     *     )
     * )
     *
     * @throws DomainException
     */
    public function delete(Product $product): JsonResponse
    {
        /** @var User $user */
        $user = Auth::user();

        if ($product->user_id !== $user->user_id) {
            throw new DomainException('You do not have own permission.');
        }

        $product->delete();

        return $this->response(
            'Product is successfully deleted.',
        );
    }
}
