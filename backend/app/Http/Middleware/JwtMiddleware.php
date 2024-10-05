<?php

namespace App\Http\Middleware;

use App\Http\Response\JsonErrorResponse;
use Closure;
use DateTimeImmutable;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Validation\Validator;
use Lcobucci\JWT\Decoder;
use Lcobucci\JWT\Token\Parser;
use Lcobucci\JWT\Validation\Constraint\LooseValidAt;
use Symfony\Component\HttpFoundation\Response;
use Tymon\JWTAuth\Exceptions\JWTException;
use Tymon\JWTAuth\Exceptions\TokenExpiredException;
use Tymon\JWTAuth\Exceptions\TokenInvalidException;
use Tymon\JWTAuth\Facades\JWTAuth;

class JwtMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        try {
        $token = JWTAuth::parseToken();
        $token->authenticate();
        

        if (!$token) {
            return response()->json(['error' => 'Token not provided'], 401);
        }

            $user = JWTAuth::setToken($token)->authenticate();

            if (!$user) {
                return (new JsonErrorResponse("User not found", 404))->send();
            }


        } catch (TokenExpiredException $e) {
            return response()->json(["message" => "Token has expired"], 401);  
        } catch (TokenInvalidException $e) {
            return (new JsonErrorResponse("Token is invalid", 401))->send();
        } catch (JWTException $e) {
            return (new JsonErrorResponse("Token is absent", 401))->send();
        }  catch(Exception $e){
            return (new JsonErrorResponse("Token error", 401))->send();
        }

        return $next($request);
    }
}
