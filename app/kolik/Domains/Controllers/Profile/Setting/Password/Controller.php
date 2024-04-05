<?php

declare(strict_types=1);

namespace App\kolik\Domains\Controllers\Profile\Setting\Password;

use App\Http\Controllers\Controller as BaseController;
use App\kolik\Domains\Request\Auth\Password\ResetLinkRequest;
use App\kolik\Domains\Request\Auth\Password\ResetRequest;
use App\kolik\Support\Core\Exceptions\DomainException;
use App\Mail\ResetPasswordLink;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;

final class Controller extends BaseController
{
    /**
     * @OA\Post(
     *     summary="Reset user password link.",
     *     path="/profiles/settings/password/email",
     *     operationId="profile-setting-password-email",
     *     tags={"profile", "setting", "password", "email"},
     *     description="Reset password",
     *     parameters={
     *      {"name": "email", "in":"query", "type":"string", "required":true, "description":"The user email for resetting the password."},
     *     },
     *
     *     @OA\Response(
     *          response=200,
     *          description="Email is successfully verified.",
     *     )
     * )
     */
    public function email(ResetLinkRequest $request): JsonResponse
    {
        Mail::to($request->getEmail())->send(new ResetPasswordLink($request->getEmail()));

        return $this->response(
            'Reset password link is successfully send.'
        );
    }

    /**
     * @OA\Post(
     *     summary="User password reset.",
     *     path="/profiles/settings/password/reset",
     *     operationId="profile-setting-password-reset",
     *     tags={"profile", "setting", "password", "reset"},
     *     description="User password reset.",
     *     parameters={
     *      {"name": "Authorization", "in":"header", "type":"string", "required":true, "description":"Bearer token"},
     *      {"name": "email", "in":"query", "type":"email", "required":true, "description":"User email"},
     *      {"name": "current_password", "in":"query", "type":"string", "required":true, "description":"Current password."},
     *      {"name": "new_password", "in":"query", "type":"string", "required":true, "description":"New password."},
     *      {"name": "new_password_confirmation", "in":"query", "type":"string", "required":true, "description":"Confirm the new Password."},
     *     },
     *
     *     @OA\RequestBody(
     *
     *          @OA\MediaType(
     *              mediaType="application/json",
     *
     *              @OA\Schema(ref="#/components/schemas/ProfileSettingPasswordResetRequest")
     *          )
     *      ),
     *
     *     @OA\Response(
     *          response=200,
     *          description="Your password is successfully reset.",
     *     )
     * )
     *
     * @throws DomainException
     */
    public function reset(ResetRequest $request): JsonResponse
    {
        $user = $request->getCurrentUser();

        $dto = $request->getDto();

        if (! Hash::check($dto->currentPasswd, $user->password)) {
            throw new DomainException('Current password is wrong.');
        }

        $user->password = bcrypt($dto->newPasswd);
        $user->save();

        return $this->response(
            'Your password is successfully reset.'
        );
    }
}
