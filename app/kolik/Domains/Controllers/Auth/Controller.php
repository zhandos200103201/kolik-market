<?php

declare(strict_types=1);

namespace App\kolik\Domains\Controllers\Auth;

use App\Http\Controllers\Controller as BaseController;
use App\kolik\Domains\Core\DTO\Auth\Login\ResponseDTO;
use App\kolik\Domains\Request\Auth\LoginRequest;
use App\kolik\Domains\Request\Auth\Password\ResetLinkRequest;
use App\kolik\Domains\Request\Auth\Password\ResetRequest;
use App\kolik\Domains\Request\Auth\RegisterRequest;
use App\kolik\Domains\Resource\Auth\LoginResource;
use App\kolik\Support\Core\Exceptions\DomainException;
use App\Mail\EmailVerification;
use App\Mail\ResetPasswordLink;
use App\Models\Role;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;

final class Controller extends BaseController
{
    /**
     * @OA\Post(
     *     summary="User registration.",
     *     path="/auth/register",
     *     operationId="auth-register",
     *     tags={"auth", "register"},
     *     description="User registration.",
     *     parameters={
     *      {"name": "name", "in":"query", "type":"string", "required":true, "description":"Name of user"},
     *      {"name": "email", "in":"query", "type":"string", "required":true, "description":"Email of user"},
     *      {"name": "password", "in":"query", "type":"string", "required":true, "description":"Password of user"},
     *      {"name": "password_confirmation", "in":"query", "type":"string", "required":true, "description":"Confirmed password of user"},
     *     },
     *
     *     @OA\Response(
     *          response=200,
     *          description="User registered.",
     *
     *          @OA\JsonContent(ref="#/components/schemas/AuthenticationLoginResource"),
     *     )
     * )
     */
    public function register(RegisterRequest $request): JsonResponse
    {
        $data = $request->getDto();

        /** @var Role $role */
        $role = Role::query()->where('title', 'Seller')->firstOrFail();

        /** @var User $user */
        $user = User::query()->insert([
            'role_id' => $role->role_id,
            'name' => $data->name,
            'email' => $data->email,
            'password' => Hash::make($data->password),
            'status' => true,
        ]);

        return $this->response(
            'User registered.',
            new LoginResource(new ResponseDTO($user, $user->createToken('Personal Access Token')->plainTextToken))
        );
    }

    /**
     * @OA\Post(
     *     summary="Logging in.",
     *     path="/auth/login",
     *     operationId="auth-login",
     *     tags={"auth", "login"},
     *     description="User logging in.",
     *     parameters={
     *      {"name": "email", "in":"query", "type":"string", "required":true, "description":"Email of user"},
     *      {"name": "password", "in":"query", "type":"string", "required":true, "description":"Password of user"},
     *     },
     *
     *     @OA\Response(
     *          response=200,
     *          description="User successfully logged in.",
     *
     *          @OA\JsonContent(ref="#/components/schemas/AuthenticationLoginResource"),
     *     )
     * )
     */
    public function login(LoginRequest $request): JsonResponse
    {
        if (! Auth::attempt($request->validated())) {
            return response()->json([
                'message' => 'Unauthorised.',
            ], 401);
        }

        /** @var User $user */
        $user = Auth::user();
        $tokenResult = $user->createToken('Personal Access Token');
        $token = $tokenResult->plainTextToken;

        return $this->response(
            'User successfully logged in.',
            new LoginResource(new ResponseDTO($user, $token))
        );
    }

    /**
     * @OA\Post(
     *     summary="User log out.",
     *     path="/auth/logout",
     *     operationId="auth-logout",
     *     tags={"auth", "logout"},
     *     description="User logging out.",
     *     parameters={
     *      {"name": "Authorization", "in":"header", "type":"string", "required":true, "description":"Bearer token"},
     *     },
     *
     *     @OA\Response(
     *          response=200,
     *          description="User successfully logged out.",
     *     )
     * )
     */
    public function logout(Request $request): JsonResponse
    {
        /** @var User $user */
        $user = $request->user();

        $user->tokens()->delete();

        return $this->response(
            'User successfully logged out.'
        );
    }

    /**
     * @OA\Post(
     *     summary="User email verification link",
     *     path="/auth/email/verify/send",
     *     operationId="auth-email-send",
     *     tags={"auth", "email", "send"},
     *     description="Send the email verification link to the email.",
     *     parameters={
     *      {"name": "Authorization", "in":"header", "type":"string", "required":true, "description":"Bearer token"},
     *     },
     *
     *     @OA\Response(
     *          response=200,
     *          description="Email verification link is successfully send.",
     *     )
     * )
     */
    public function send(): JsonResponse
    {
        /** @var User $user */
        $user = Auth::user();

        Mail::to($user->email)->send(new EmailVerification($user->email));

        return $this->response(
            'Email verification link is successfully send.'
        );
    }

    /**
     * @OA\Post(
     *     summary="User email verification.",
     *     path="/auth/email/verify",
     *     operationId="auth-email-verify",
     *     tags={"auth", "email", "verify"},
     *     description="Email verification",
     *     parameters={
     *      {"name": "Authorization", "in":"header", "type":"string", "required":true, "description":"Bearer token"},
     *      {"name": "password", "in":"query", "type":"string", "required":true, "description":"New password."},
     *      {"name": "password_confirmation", "in":"query", "type":"string", "required":true, "description":"Confirm the new Password."},
     *     },
     *
     *     @OA\Response(
     *          response=200,
     *          description="Email is successfully verified.",
     *     )
     * )
     */
    public function verify(): JsonResponse
    {
        /** @var User $user */
        $user = Auth::user();

        if (! $user->email_verified_at) {
            $user->forceFill([
                'email_verified_at' => now(),
            ])->save();
        }

        return $this->response(
            'Email is successfully verified.'
        );
    }

    /**
     * @OA\Post(
     *     summary="Reset user password link.",
     *     path="/auth/password/email",
     *     operationId="auth-password-email",
     *     tags={"auth", "password", "email"},
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
     *     path="/auth/password/reset",
     *     operationId="auth-password-reset",
     *     tags={"auth", "password", "reset"},
     *     description="User password reset.",
     *     parameters={
     *      {"name": "Authorization", "in":"header", "type":"string", "required":true, "description":"Bearer token"},
     *      {"name": "password", "in":"query", "type":"string", "required":true, "description":"New password."},
     *      {"name": "password_confirmation", "in":"query", "type":"string", "required":true, "description":"Confirm the new Password."},
     *     },
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
        /** @var User $user */
        $user = User::query()->where('email', $request->getEmail())->first();

        if (! $user) {
            throw new DomainException('User with this email does not exists.');
        }

        $user->email = bcrypt($request->getPassword());
        $user->save();

        return $this->response(
            'Your password is successfully reset.'
        );
    }
}
