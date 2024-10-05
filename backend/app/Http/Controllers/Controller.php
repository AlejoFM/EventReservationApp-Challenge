<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;

/**
 * @OA\Info(
 *     title="API de Autenticación",
 *     version="1.0.0"
 * )
 *@OA\SecurityScheme(
    *    securityScheme="bearerAuth",
    *    in="header",
    *    name="bearerAuth",
    *    type="http",
    *    scheme="bearer",
    *    bearerFormat="JWT",
    * ),
    */
class Controller extends BaseController
{
    use AuthorizesRequests, ValidatesRequests;
}
