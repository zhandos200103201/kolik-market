<?php

declare(strict_types=1);

namespace App\kolik\Domains\Controllers\Profile\Setting\Info;

use App\Http\Controllers\Controller as BaseController;
use App\kolik\Domains\Request\Profile\Setting\Info\UpdateRequest;
use App\kolik\Domains\Resource\Profile\Setting\Info\IndexResource;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;

final class Controller extends BaseController
{
    /**
     * @OA\Get (
     *     summary="Get user profile",
     *     path="/profiles/settings/info",
     *     operationId="profile-setting-info-index",
     *     tags={"profile", "setting", "info"},
     *     description="Get user information.",
     *     parameters={
     *      {"name": "Authorization", "in":"header", "type":"string", "required":true, "description":"Bearer token"},
     *     },
     *
     *     @OA\Response(
     *          response=200,
     *          description="Profile info is successfully retrieved.",
     *
     *          @OA\JsonContent(ref="#/components/schemas/ProfileSettingInfoIndexResource"),
     *     )
     * )
     */
    public function index(): JsonResponse
    {
        /** @var User $user */
        $user = Auth::user();

        return $this->response(
            'Profile info is successfully retrieved.',
            new IndexResource($user)
        );
    }

    /**
     * @OA\Put (
     *     summary="Set user profile",
     *     path="/profiles/settings/info",
     *     operationId="profile-setting-info-update",
     *     tags={"profile", "setting", "info"},
     *     description="Update user information.",
     *     parameters={
     *      {"name": "Authorization", "in":"header", "type":"string", "required":true, "description":"Bearer token"},
     *      {"name": "name", "in":"header", "type":"string", "required":true, "description":"User name"},
     *      {"name": "email", "in":"header", "type":"string", "required":true, "description":"New user email"},
     *      {"name": "address", "in":"header", "type":"string", "required":true, "description":"New user address"},
     *      {"name": "photo", "in":"header", "type":"string", "required":true, "description":"New user photo"},
     *     },
     *
     *     @OA\RequestBody(
     *
     *         @OA\MediaType(
     *             mediaType="application/json",
     *
     *             @OA\Schema(ref="#/components/schemas/ProfileSettingInfoUpdateRequest")
     *         )
     *     ),
     *
     *     @OA\Response(
     *          response=200,
     *          description="Profile info is successfully updated.",
     *     )
     * )
     */
    public function update(UpdateRequest $request): JsonResponse
    {
        $dto = $request->getDto();

        /** @var User $user */
        $user = Auth::user();

        User::query()
            ->where('email', $user->email)
            ->update([
                'name' => $dto->name,
                'email' => $dto->email,
                'address' => $dto->address,
                'photo' => $dto->photo,
                'email_verified_at' => null,
            ]);

        return $this->response(
            'Profile info is successfully updated.',
        );
    }
}
