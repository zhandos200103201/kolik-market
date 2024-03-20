<?php

namespace App\Http\Controllers;

use App\kolik\Support\Core\Traits\ResponseTrait;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;

/**
 * @OA\Info(
 *      title="kolik-market.kz",
 *      version="1.0",
 *      description="",
 *
 *      @OA\Contact(
 *          email="200103201@stu.sdu.edu.kz"
 *      ),
 * )
 */
abstract class Controller extends BaseController
{
    use AuthorizesRequests, ResponseTrait, ValidatesRequests;
}
