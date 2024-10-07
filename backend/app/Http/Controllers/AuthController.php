<?php

namespace App\Http\Controllers;

use App\Http\Response\JsonErrorResponse;
use App\Http\Response\JsonSuccesfulBodyResponse;
use App\Http\Response\JsonSuccesfulResponse;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Tymon\JWTAuth\Facades\JWTAuth;
use Tymon\JWTAuth\Exceptions\JWTException;

/**
 * @OA\Tag(
 *     name="Auth", 
 *     description="API relacionada a la autenticación"
 * )
 */

class AuthController extends Controller
{
    /**
     * @OA\Post(
     *     path="/api/register",
     *     summary="Registro de usuario",
     *      tags={"Authentication"},
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             required={"name", "email", "password"},
     *             @OA\Property(property="name", type="string", example="Juan Perez"),
     *             @OA\Property(property="email", type="string", example="juan@example.com"),
     *             @OA\Property(property="password", type="string", example="password123")
     *         )
     *     ),
     *     @OA\Response(
     *         response=201,
     *         description="Usuario registrado exitosamente"
     *     ),
     *     @OA\Response(
     *         response=422,
     *         description="Datos inválidos"
     *     )
     * )
     */
    public function register(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:6',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => bcrypt($request->password),
        ]);
        return response()->json(["user" => $user], 201)->send();
    }

    /**
     * @OA\Post(
     *     path="/api/login",
     *     summary="Inicio de sesión de usuario",
     *       tags={"Authentication"},
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             required={"email", "password"},
     *             @OA\Property(property="email", type="string", example="juan@example.com"),
     *             @OA\Property(property="password", type="string", example="secreta123")
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Inicio de sesión exitoso",
     *         @OA\JsonContent(
     *             @OA\Property(property="token", type="string", example="eyJhbGciOiJIUzI1NiIsInR5cCI6IkpXVCJ9...")
     *         )
     *     ),
     *     @OA\Response(
     *         response=401,
     *         description="Credenciales inválidas"
     *     )
     * )
     */
    public function login(Request $request)
    {
        $credentials = $request->only('email', 'password');

        $user = User::where('email', $request->email)->first();

        if (!$user || !Hash::check($request->password, $user->password)) {
            return (new JsonErrorResponse("Wrong credentials", 400))->send();
        }
        try {
            
            if (!$token = JWTAuth::attempt($credentials)) {
                return (new JsonErrorResponse("Wrong credentials", 401))->send();
            }
            $token = JWTAuth::fromUser($user);

        } catch (JWTException $e) {
            return (new JsonErrorResponse("JWT Token creation error", 500))->send();
        }
        $customClaims = ['role' => $user->role];
        $token = JWTAuth::claims($customClaims)->fromUser($user);
        return (new JsonSuccesfulBodyResponse(compact('token')))->send();
    }

    /**
     * @OA\Get(
     *     path="/api/logout",
     *     summary="Cerrar sesión de usuario",
     *       tags={"Authentication"},
     *     @OA\Response(
     *         response=200,
     *         description="Cierre de sesión exitoso"
     *     ),
     *     @OA\Response(
     *         response=401,
     *         description="Token inválido"
     *     )
     * )
     */
    public function logout()
    {
        auth()->logout();
        return (new JsonSuccesfulResponse("Succesful logout"))->send();
    }
}
