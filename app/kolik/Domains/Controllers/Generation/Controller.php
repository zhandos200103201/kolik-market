<?php

declare(strict_types=1);

namespace App\kolik\Domains\Controllers\Generation;

use App\Http\Controllers\Controller as BaseController;
use App\kolik\Domains\Request\Generation\ManageRequest;
use App\Models\ModelGeneration;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;

final class Controller extends BaseController
{
    /**
     * @OA\Get(
     *     summary="Get model generation",
     *     path="/generations",
     *     operationId="generation-index",
     *     tags={"generation"},
     *     description="Get car model generations",
     *     parameters={},
     *
     *     @OA\Response(
     *          response=200,
     *          description="Model generations are successfully retrieved.",
     *     ),
     * )
     */
    public function index(): JsonResponse
    {
        return response()->json([
            'message' => 'Model generations are successfully retrieved.',
            'data' => ModelGeneration::all(),
        ]);
    }

    /**
     * @OA\Post(
     *     summary="Create a new model generation",
     *     path="/generations",
     *     operationId="generation-create",
     *     tags={"generation"},
     *     description="Create a new model generation",
     *     parameters={
     *       {"name": "Authorization", "in":"header", "type":"string", "required":true, "description":"Bearer token"},
     *     },
     *
     *     @OA\RequestBody(
     *
     *          @OA\MediaType(
     *              mediaType="application/json",
     *
     *              @OA\Schema(ref="#/components/schemas/GenerationManageRequest")
     *          )
     *      ),
     *
     *     @OA\Response(
     *          response=200,
     *          description="New generation of the model is successfully created.",
     *     )
     * )
     */
    public function create(ManageRequest $request): JsonResponse
    {
        /** @var User $user */
        $user = Auth::user();

        if ($user->role_id !== 2) {
            return response()->json([
                'message' => 'Only admins can change the manufacturer.',
            ]);
        }

        $dto = $request->getDto();

        $newGeneration = ModelGeneration::query()->create([
            'model_id' => $dto->modelId,
            'start_year' => $dto->startYear,
            'end_year' => $dto->endYear,
        ]);

        return response()->json([
            'message' => 'New generation of the model is successfully created.',
            'data' => $newGeneration,
        ]);
    }

    /**
     * @OA\Put(
     *     summary="Update the model generation",
     *     path="/generation",
     *     operationId="generation-update",
     *     tags={"generation"},
     *     description="Update a model generation",
     *     parameters={},
     *
     *     @OA\RequestBody(
     *
     *          @OA\MediaType(
     *              mediaType="application/json",
     *
     *              @OA\Schema(ref="#/components/schemas/GenerationManageRequest")
     *          )
     *      ),
     *
     *     @OA\Response(
     *          response=200,
     *          description="New generation of the model is successfully created.",
     *     )
     * )
     */
    public function update(ModelGeneration $generation, ManageRequest $request): JsonResponse
    {
        /** @var User $user */
        $user = Auth::user();

        if ($user->role_id !== 2) {
            return response()->json([
                'message' => 'Only admins can change the manufacturer.',
            ]);
        }

        $dto = $request->getDto();

        $generation->update([
            'model_id' => $dto->modelId,
            'start_year' => $dto->startYear,
            'end_year' => $dto->endYear,
        ]);

        return response()->json([
            'message' => 'Generation is successfully updated.',
            'data' => $generation,
        ]);
    }

    /**
     * @OA\Delete(
     *     summary="Delete the model generation",
     *     path="/generation",
     *     operationId="generation-delete",
     *     tags={"generation"},
     *     description="Delete a model generation",
     *     parameters={},
     *
     *     @OA\Response(
     *          response=200,
     *          description="Generation is successfully deleted.",
     *     )
     * )
     */
    public function delete(ModelGeneration $generation): JsonResponse
    {
        /** @var User $user */
        $user = Auth::user();

        if ($user->role_id !== 2) {
            return response()->json([
                'message' => 'Only admins can delete the generation.',
            ]);
        }

        $generation->delete();

        return response()->json([
            'message' => 'Generation is successfully deleted.',
        ]);
    }
}
