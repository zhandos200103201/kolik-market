<?php

declare(strict_types=1);

namespace App\kolik\Domains\Controllers\Model;

use App\Http\Controllers\Controller as BaseController;
use App\kolik\Domains\Request\Model\ManageRequest;
use App\kolik\Domains\Resource\Model\IndexResource;
use App\Models\CarModel;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;

final class Controller extends BaseController
{
    /**
     * @OA\Get(
     *     summary="Get all car models.",
     *     path="/models",
     *     operationId="model-index",
     *     tags={"model"},
     *     description="Get all car models",
     *     parameters={
     *      {"name": "Authorization", "in":"header", "type":"string", "required":true, "description":"Bearer token"},
     *     },
     *
     *     @OA\Response(
     *          response=200,
     *          description="Models of the cars are successfully retrieved.",
     *
     *          @OA\JsonContent(ref="#/components/schemas/CityIndexResource"),
     *     )
     * )
     */
    public function index(): JsonResponse
    {
        return $this->response(
            'Models of the cars are successfully retrieved.',
            IndexResource::collection(CarModel::all())
        );
    }

    /**
     * @OA\Post(
     *     summary="Create a new car model.",
     *     path="/models",
     *     operationId="model-create",
     *     tags={"model"},
     *     description="Create a new model",
     *     parameters={
     *      {"name": "Authorization", "in":"header", "type":"string", "required":true, "description":"Bearer token"},
     *      {"name": "model_name", "in":"header", "type":"string", "required":true, "description":"Model Name"},
     *      {"name": "manufacturer_id", "in":"header", "type":"integer", "required":true, "description":"Manufacturer ID"},
     *     },
     *
     *     @OA\RequestBody(
     *
     *          @OA\MediaType(
     *              mediaType="application/json",
     *
     *              @OA\Schema(ref="#/components/schemas/ModelManageRequest")
     *          )
     *      ),
     *
     *     @OA\Response(
     *          response=200,
     *          description="Model of the car is successfully created.",
     *
     *          @OA\JsonContent(ref="#/components/schemas/ModelIndexResource"),
     *     )
     * )
     */
    public function create(ManageRequest $request): JsonResponse
    {
        /** @var User $user */
        $user = Auth::user();

        if ($user->role_id !== 2) {
            return $this->response('You do not have own permission.');
        }

        $dto = $request->getDto();

        $newModel = CarModel::query()->create([
            'name' => $dto->modelName,
            'manufacturer_id' => $dto->manufacturerId,
        ]);

        return $this->response(
            'Model of the car is successfully created.',
            new IndexResource($newModel)
        );
    }

    /**
     * @OA\Put (
     *     summary="Update the car model",
     *     path="/models",
     *     operationId="model-update",
     *     tags={"model"},
     *     description="Update model name.",
     *     parameters={
     *      {"name": "Authorization", "in":"header", "type":"string", "required":true, "description":"Bearer token"},
     *      {"name": "model", "in":"header", "type":"integer", "required":true, "description":"Car model ID"},
     *     },
     *
     *     @OA\RequestBody(
     *
     *         @OA\MediaType(
     *             mediaType="application/json",
     *
     *             @OA\Schema(ref="#/components/schemas/ModelManageRequest")
     *         )
     *     ),
     *
     *     @OA\Response(
     *          response=200,
     *          description="Model of the car is successfully updated.",
     *
     *          @OA\JsonContent(ref="#/components/schemas/ModelIndexResource"),
     *     )
     * )
     */
    public function update(CarModel $model, ManageRequest $request): JsonResponse
    {
        /** @var User $user */
        $user = Auth::user();

        if ($user->role_id !== 2) {
            return $this->response('You do not have own permission.');
        }

        $dto = $request->getDto();

        $model->update([
            'name' => $dto->modelName,
            'manufacturer_id' => $dto->manufacturerId,
        ]);

        return $this->response(
            'Model of the car is successfully updated.',
            new IndexResource($model)
        );
    }

    /**
     * @OA\Delete(
     *     summary="Delete the car model",
     *     path="/models",
     *     operationId="model-delete",
     *     tags={"model"},
     *     description="Delete the car model",
     *     parameters={
     *       {"name": "Authorization", "in":"header", "type":"string", "required":true, "description":"Bearer token"},
     *       {"name": "model", "in":"header", "type":"integer", "required":true, "description":"Car model id"},
     *     },
     *
     *     @OA\Response(
     *          response=200,
     *          description="Model of the car is successfully deleted.",
     *     )
     * )
     */
    public function delete(CarModel $model): JsonResponse
    {
        /** @var User $user */
        $user = Auth::user();

        if ($user->role_id !== 2) {
            return $this->response('You do not have own permission.');
        }

        $model->delete();

        return $this->response('Model of the car is successfully deleted.');
    }
}
