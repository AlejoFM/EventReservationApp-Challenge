<?php

namespace App\Http\Middleware;

use App\Http\Response\JsonErrorResponse;
use App\Models\User;
use Closure;
use DateTimeImmutable;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Validator;
use Symfony\Component\HttpFoundation\Response;
use Tymon\JWTAuth\Exceptions\JWTException;
use Tymon\JWTAuth\Exceptions\TokenExpiredException;
use Tymon\JWTAuth\Exceptions\TokenInvalidException;
use Tymon\JWTAuth\Facades\JWTAuth;

class IsAdminMiddleware
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
            $userData = auth()->user();

    
            if (!$userData) {
                return response()->json(['status' => 'error', 'message' => 'User not found'], 404);
            }
    
            $userIsAdmin = $userData->role;
            if (Auth::user()->role != 'admin') {
                return response()->json(['status' => 'error', 'message' => 'Access denied'], 403);

            }
            if (empty($userIsAdmin)) {
                return response()->json(['status' => 'error', 'message' => 'Access denied'], 403);
            }
            if($userIsAdmin != "admin"){
                return response()->json(['status' => 'error', 'message' => 'Access denied'], 403);
            }

        } catch (TokenExpiredException $e) {
            return response()->json(['status' => 'error', "message" => "Token has expired"], 401);  
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
