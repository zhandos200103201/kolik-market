<?php

declare(strict_types=1);

namespace App\kolik\Domains\Controllers\Auth;

use App\Http\Controllers\Controller as BaseController;
use App\kolik\Domains\Core\DTO\Auth\Login\ResponseDTO;
use App\kolik\Domains\Request\Auth\LoginRequest;
use App\kolik\Domains\Request\Auth\RegisterRequest;
use App\kolik\Domains\Resource\Auth\LoginResource;
use App\kolik\Support\Core\Enums\Role;
use App\kolik\Support\Core\Exceptions\DomainException;
use App\Mail\EmailVerification;
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
     *      {"name": "phone", "in":"query", "type":"string", "required":true, "description":"Phone number of user"},
     *     },
     *
     *     @OA\Response(
     *          response=200,
     *          description="User registered.",
     *
     *          @OA\JsonContent(ref="#/components/schemas/AuthenticationLoginResource"),
     *     )
     * )
     *
     * @throws DomainException
     */
    public function register(RegisterRequest $request): JsonResponse
    {
        $data = $request->getDto();

        $user = User::query()->create([
            'name' => $data->name,
            'email' => $data->email,
            'password' => Hash::make($data->password),
            'phone' => $data->phone,
            'status' => true,
            'role_id' => Role::SELLER,
        ]);

        if (! $user) {
            throw new DomainException('User does not created.');
        }

        Mail::to($data->email)->send(new EmailVerification($data->email));

        return $this->response(
            'User is successfully registered.',
            'Проверьте свою почту, и подтвердите.'
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
     *
     * @throws DomainException
     */
    public function login(LoginRequest $request): JsonResponse
    {
        if (! Auth::attempt($request->validated())) {
            throw new DomainException('User email or password is wrong.');
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
     *
     * @throws DomainException
     */
    public function send(): JsonResponse
    {
        /** @var User $user */
        $user = Auth::user();

        if ($user->email_verified_at !== null) {
            throw new DomainException('Your email is already verified');
        }

        Mail::to($user->email)->send(new EmailVerification($user->email));

        return $this->response(
            'Email verification link is successfully send.'
        );
    }

    public function verify(Request $request): JsonResponse
    {
        User::query()->where('email', $request->get('email'))->update([
            'email_verified_at' => now(),
        ]);

        return $this->response(
            'Email is successfully verified.'
        );
    }
}
