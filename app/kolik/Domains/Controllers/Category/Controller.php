<?php

declare(strict_types=1);

namespace App\kolik\Domains\Controllers\Category;

use App\Http\Controllers\Controller as BaseController;
use App\kolik\Domains\Request\Category\ManageRequest;
use App\kolik\Domains\Resource\Category\IndexResource;
use App\Models\Category;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;

final class Controller extends BaseController
{
    /**
     * @OA\Get(
     *     summary="Get product categories",
     *     path="/categories",
     *     operationId="category-index",
     *     tags={"category"},
     *     description="Get all product categories",
     *     parameters={
     *       {"name": "Authorization", "in":"header", "type":"string", "required":true, "description":"Bearer token"},
     *     },
     *
     *     @OA\Response(
     *           response=200,
     *           description="Categories are successfully retrieved.",
     *
     *           @OA\JsonContent(ref="#/components/schemas/CategoryIndexResource"),
     *      )
     * )
     */
    public function index(): JsonResponse
    {
        return $this->response(
            'Categories are successfully retrieved.',
            IndexResource::collection(Category::all())
        );
    }

    /**
     * @OA\Post(
     *     summary="Create a new product category",
     *     path="/categories",
     *     operationId="category-create",
     *     tags={"category"},
     *     description="Create a new product category",
     *     parameters={
     *       {"name": "Authorization", "in":"header", "type":"string", "required":true, "description":"Bearer token"},
     *       {"name": "name", "in":"header", "type":"string", "required":true, "description":"Name of category"},
     *       {"name": "description", "in":"header", "type":"string", "required":true, "description":"Description of category"},
     *     },
     *
     *     @OA\RequestBody(
     *
     *          @OA\MediaType(
     *              mediaType="application/json",
     *
     *              @OA\Schema(ref="#/components/schemas/CategoryManageRequest")
     *          )
     *      ),
     *
     *     @OA\Response(
     *          response=200,
     *          description="Category is successfully created.",
     *     )
     * )
     */
    public function create(ManageRequest $request): JsonResponse
    {
        $dto = $request->getDto();

        $newCategory = Category::query()->create([
            'name' => $dto->name,
            'description' => $dto->description,
        ]);

        return $this->response(
            'Category is successfully created.',
            new IndexResource($newCategory)
        );
    }

    /**
     * @OA\Put(
     *     summary="Updaet the model generation",
     *     path="/categories",
     *     operationId="category-update",
     *     tags={"category"},
     *     description="Update the category",
     *     parameters={
     *       {"name": "Authorization", "in":"header", "type":"string", "required":true, "description":"Bearer token"},
     *       {"name": "category", "in":"header", "type":"integer", "required":true, "description":"Id of category"},
     *     },
     *
     *     @OA\RequestBody(
     *
     *          @OA\MediaType(
     *              mediaType="application/json",
     *
     *              @OA\Schema(ref="#/components/schemas/CategoryManageRequest")
     *          )
     *      ),
     *
     *     @OA\Response(
     *          response=200,
     *          description="Category is successfully updated.",
     *     )
     * )
     */
    public function update(Category $category, ManageRequest $request): JsonResponse
    {
        $dto = $request->getDto();

        $category->update([
            'name' => $dto->name,
            'description' => $dto->description,
        ]);

        return $this->response(
            'Category is successfully updated.',
            new IndexResource($category)
        );
    }

    /**
     * @OA\Delete(
     *     summary="Delete the product category",
     *     path="/categories",
     *     operationId="category-delete",
     *     tags={"category"},
     *     description="Delete a product category",
     *     parameters={
     *       {"name": "Authorization", "in":"header", "type":"string", "required":true, "description":"Bearer token"},
     *       {"name": "category", "in":"header", "type":"integer", "required":true, "description":"ID of category"},
     *     },
     *
     *     @OA\Response(
     *          response=200,
     *          description="Category is successfully deleted.",
     *     )
     * )
     */
    public function delete(Category $category): JsonResponse
    {
        /** @var User $user */
        $user = Auth::user();

        if ($user->role_id !== 2) {
            return $this->response('You do not have own permission.');
        }

        $category->delete();

        return $this->response(
            'Category is successfully deleted.',
        );
    }
}
