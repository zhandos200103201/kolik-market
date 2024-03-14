<?php

declare(strict_types=1);

namespace App\Http\Requests;

use App\Models\User;
use Illuminate\Foundation\Http\FormRequest;

abstract class Request extends FormRequest
{
    protected const DEVICE_INFO_PARAMETER = 'HTTP_USER_AGENT';

    abstract public function rules(): array;

    public function getCurrentUser(): User
    {
        return $this->user();
    }

    public function authorize(): bool
    {
        return true;
    }

    public function getDeviceInfo(): string
    {
        return (string) $this->server(self::DEVICE_INFO_PARAMETER);
    }
}
