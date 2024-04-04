<?php

declare(strict_types=1);

namespace App\kolik\Domains\Controllers\Manufacturer;

use App\Http\Controllers\Controller as BaseController;
use App\kolik\Domains\Request\Manufacturer\ManageRequest;
use App\kolik\Domains\Resource\Manufacturer\IndexResource;
use App\Models\Manufacturer;
use Illuminate\Http\JsonResponse;

final class Controller extends BaseController
{
    /**
     * @OA\Get(
     *     summary="Get all manufactures.",
     *     path="/manufacturers",
     *     operationId="manufacturer-index",
     *     tags={"manufacturer"},
     *     description="Manufacturer like: Toyota, Mercedes",
     *     parameters={
     *      {"name": "Authorization", "in":"header", "type":"string", "required":true, "description":"Bearer token"},
     *     },
     *
     *     @OA\Response(
     *          response=200,
     *          description="Manufacturers are successfully retrieved.",
     *
     *          @OA\JsonContent(ref="#/components/schemas/ManufacturerIndexResource"),
     *     )
     * )
     */
    public function index(): JsonResponse
    {
        return $this->response(
            'Manufacturers are successfully retrieved.',
            IndexResource::collection(Manufacturer::all())
        );
    }

    /**
     * @OA\Post(
     *     summary="Create a new manufacturer.",
     *     path="/manufacturers",
     *     operationId="manufacturer-create",
     *     tags={"manufacturer"},
     *     description="Create a new manufacturer",
     *     parameters={
     *      {"name": "Authorization", "in":"header", "type":"string", "required":true, "description":"Bearer token"},
     *      {"name": "name", "in":"header", "type":"string", "required":true, "description":"Manufacturer Name"},
     *     },
     *
     *     @OA\RequestBody(
     *
     *          @OA\MediaType(
     *              mediaType="application/json",
     *
     *              @OA\Schema(ref="#/components/schemas/ManufacturerManageRequest")
     *          )
     *      ),
     *
     *     @OA\Response(
     *          response=200,
     *          description="Manufacturer is successfully created.",
     *
     *          @OA\JsonContent(ref="#/components/schemas/ManufacturerIndexResource"),
     *     )
     * )
     */
    public function create(ManageRequest $request): JsonResponse
    {
        $newManufacturer = Manufacturer::query()->create([
            'name' => $request->getName(),
        ]);

        return $this->response(
            'Manufacturer is successfully created.',
            new IndexResource($newManufacturer)
        );
    }

    /**
     * @OA\Put (
     *     summary="Update the manufacturer.",
     *     path="/manufacturers",
     *     operationId="manufacturer-update",
     *     tags={"manufacturer"},
     *     description="Update manufacturer name.",
     *     parameters={
     *      {"name": "Authorization", "in":"header", "type":"string", "required":true, "description":"Bearer token"},
     *      {"name": "name", "in":"header", "type":"string", "required":true, "description":"Manufacturer name"},
     *     },
     *
     *     @OA\RequestBody(
     *
     *         @OA\MediaType(
     *             mediaType="application/json",
     *
     *             @OA\Schema(ref="#/components/schemas/ManufacturerManageRequest")
     *         )
     *     ),
     *
     *     @OA\Response(
     *          response=200,
     *          description="Manufacturer is successfully updated.",
     *
     *          @OA\JsonContent(ref="#/components/schemas/ManufacturerIndexResource"),
     *     )
     * )
     */
    public function update(Manufacturer $manufacturer, ManageRequest $request): JsonResponse
    {
        $manufacturer->update([
            'name' => $request->getName(),
        ]);

        return $this->response(
            'Manufacturer is successfully updated.',
            new IndexResource($manufacturer)
        );
    }

    /**
     * @OA\Delete(
     *     summary="Delete the manufacturer.",
     *     path="/manufacturers",
     *     operationId="manufacturer-delete",
     *     tags={"manufacturer"},
     *     description="Delete the manufacturer.",
     *     parameters={
     *       {"name": "Authorization", "in":"header", "type":"string", "required":true, "description":"Bearer token"},
     *       {"name": "city", "in":"header", "type":"integer", "required":true, "description":"ID of city"},
     *     },
     *
     *     @OA\Response(
     *          response=200,
     *          description="Manufacturer is successfully deleted.",
     *     )
     * )
     */
    public function delete(Manufacturer $manufacturer): JsonResponse
    {
        $manufacturer->delete();

        return $this->response('Manufacturer is successfully deleted.');
    }
}
