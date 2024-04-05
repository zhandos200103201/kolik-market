<?php

declare(strict_types=1);

namespace App\kolik\Domains\Controllers\Generation;

use App\Http\Controllers\Controller as BaseController;
use App\kolik\Domains\Request\Generation\ManageRequest;
use App\kolik\Domains\Resource\Generation\IndexResource;
use App\Models\ModelGeneration;
use Illuminate\Http\JsonResponse;

final class Controller extends BaseController
{
    /**
     * @OA\Get(
     *     summary="Get model generation",
     *     path="/generations",
     *     operationId="generation-index",
     *     tags={"generation"},
     *     description="Get car model generations",
     *     parameters={
     *       {"name": "Authorization", "in":"header", "type":"string", "required":true, "description":"Bearer token"},
     *      },
     *
     *     @OA\Response(
     *          response=200,
     *          description="Model generations are successfully retrieved.",
     *
     *          @OA\JsonContent(ref="#/components/schemas/ModelGenerationIndexResource"),
     *     ),
     * )
     */
    public function index(): JsonResponse
    {
        return $this->response(
            'Model generations are successfully retrieved.',
            IndexResource::collection(ModelGeneration::all())
        );
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
     *       {"name": "model_id", "in":"header", "type":"integer", "required":true, "description":"Id of car model"},
     *       {"name": "start_year", "in":"header", "type":"integer", "required":true, "description":"start generation year"},
     *       {"name": "end_year", "in":"header", "type":"integer", "required":true, "description":"end generation year"},
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
     *
     *          @OA\JsonContent(ref="#/components/schemas/ModelGenerationIndexResource"),
     *     )
     * )
     */
    public function create(ManageRequest $request): JsonResponse
    {
        $dto = $request->getDto();

        $newGeneration = ModelGeneration::query()->create([
            'model_id' => $dto->modelId,
            'start_year' => $dto->startYear,
            'end_year' => $dto->endYear,
        ]);

        return $this->response(
            'New generation of the model is successfully created.',
            new IndexResource($newGeneration)
        );
    }

    /**
     * @OA\Put(
     *     summary="Update the model generation",
     *     path="/generations",
     *     operationId="generation-update",
     *     tags={"generation"},
     *     description="Update a model generation",
     *     parameters={
     *       {"name": "Authorization", "in":"header", "type":"string", "required":true, "description":"Bearer token"},
     *       {"name": "generation", "in":"header", "type":"integer", "required":true, "description":"Id of model generation"},
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
     *          description="The generation of the model is successfully updated.",
     *
     *          @OA\JsonContent(ref="#/components/schemas/ModelGenerationIndexResource"),
     *     )
     * )
     */
    public function update(ModelGeneration $generation, ManageRequest $request): JsonResponse
    {
        $dto = $request->getDto();

        $generation->update([
            'model_id' => $dto->modelId,
            'start_year' => $dto->startYear,
            'end_year' => $dto->endYear,
        ]);

        return $this->response(
            'The generation of the model is successfully updated.',
            new IndexResource($generation)
        );
    }

    /**
     * @OA\Delete(
     *     summary="Delete the model generation",
     *     path="/generations",
     *     operationId="generation-delete",
     *     tags={"generation"},
     *     description="Delete a model generation",
     *     parameters={
     *       {"name": "Authorization", "in":"header", "type":"string", "required":true, "description":"Bearer token"},
     *       {"name": "generation", "in":"header", "type":"integer", "required":true, "description":"Id of generation"},
     *     },
     *
     *     @OA\Response(
     *          response=200,
     *          description="Generation is successfully deleted.",
     *     )
     * )
     */
    public function delete(ModelGeneration $generation): JsonResponse
    {
        $generation->delete();

        return $this->response('Generation is successfully deleted.');
    }
}
