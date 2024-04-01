<?php

declare(strict_types=1);

namespace App\kolik\Domains\Controllers\City;

use App\Http\Controllers\Controller as BaseController;
use App\kolik\Domains\Request\City\ManageRequest;
use App\kolik\Domains\Resource\City\IndexResource;
use App\Models\City;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;

final class Controller extends BaseController
{
    /**
     * @OA\Get(
     *     summary="Get all cities.",
     *     path="/cities",
     *     operationId="city-index",
     *     tags={"city"},
     *     description="Kazakhstan cities",
     *     parameters={
     *      {"name": "Authorization", "in":"header", "type":"string", "required":true, "description":"Bearer token"},
     *     },
     *
     *     @OA\Response(
     *          response=200,
     *          description="Cities are successfully retrieved.",
     *
     *          @OA\JsonContent(ref="#/components/schemas/CityIndexResource"),
     *     )
     * )
     */
    public function index(): JsonResponse
    {
        return $this->response(
            'Cities are successfully retrieved.',
            IndexResource::collection(City::all()),
        );
    }

    /**
     * @OA\Post(
     *     summary="Create a new city.",
     *     path="/cities",
     *     operationId="city-create",
     *     tags={"city"},
     *     description="Create a new city",
     *     parameters={
     *      {"name": "Authorization", "in":"header", "type":"string", "required":true, "description":"Bearer token"},
     *      {"name": "city", "in":"header", "type":"string", "required":true, "description":"City Name"},
     *     },
     *
     *     @OA\RequestBody(
     *
     *          @OA\MediaType(
     *              mediaType="application/json",
     *
     *              @OA\Schema(ref="#/components/schemas/CityManageRequest")
     *          )
     *      ),
     *
     *     @OA\Response(
     *          response=200,
     *          description="New city is successfully created.",
     *
     *          @OA\JsonContent(ref="#/components/schemas/CityIndexResource"),
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

        $newCity = City::query()->create([
            'name' => $request->getCity(),
        ]);

        return $this->response(
            'New city is successfully created.',
            new IndexResource($newCity),
        );
    }

    /**
     * @OA\Put (
     *     summary="Set city",
     *     path="/cities",
     *     operationId="city-update",
     *     tags={"city"},
     *     description="Update city name.",
     *     parameters={
     *      {"name": "Authorization", "in":"header", "type":"string", "required":true, "description":"Bearer token"},
     *      {"name": "city", "in":"header", "type":"integer", "required":true, "description":"City ID"},
     *     },
     *
     *     @OA\RequestBody(
     *
     *         @OA\MediaType(
     *             mediaType="application/json",
     *
     *             @OA\Schema(ref="#/components/schemas/CityManageRequest")
     *         )
     *     ),
     *
     *     @OA\Response(
     *          response=200,
     *          description="City is successfully updated.",
     *
     *          @OA\JsonContent(ref="#/components/schemas/CityIndexResource"),
     *     )
     * )
     */
    public function update(City $city, ManageRequest $request): JsonResponse
    {
        /** @var User $user */
        $user = Auth::user();

        if ($user->role_id !== 2) {
            return $this->response('You do not have own permission.');
        }

        $city->update([
            'name' => $request->getCity(),
        ]);

        return $this->response(
            'City is successfully updated.',
            new IndexResource($city),
        );
    }

    /**
     * @OA\Delete(
     *     summary="Delete the city",
     *     path="/cities",
     *     operationId="city-delete",
     *     tags={"city"},
     *     description="Delete the city",
     *     parameters={
     *       {"name": "Authorization", "in":"header", "type":"string", "required":true, "description":"Bearer token"},
     *       {"name": "city", "in":"header", "type":"integer", "required":true, "description":"ID of city"},
     *     },
     *
     *     @OA\Response(
     *          response=200,
     *          description="City is successfully deleted.",
     *     )
     * )
     */
    public function delete(City $city): JsonResponse
    {
        /** @var User $user */
        $user = Auth::user();

        if ($user->role_id !== 2) {
            return $this->response('You do not have own permission.');
        }

        $city->delete();

        return $this->response('City is successfully deleted.');
    }
}
