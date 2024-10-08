<?php

namespace App\Exceptions;

use App\Http\Response\JsonErrorResponse;
use Exception;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Illuminate\Support\Facades\Log;
use Illuminate\Validation\ValidationException;
use Throwable;

class Handler extends ExceptionHandler
{
    /**
     * A list of exception types with their corresponding custom log levels.
     *
     * @var array<class-string<\Throwable>, \Psr\Log\LogLevel::*>
     */
    protected $levels = [
        //
    ];

    /**
     * A list of the exception types that are not reported.
     *
     * @var array<int, class-string<\Throwable>>
     */
    protected $dontReport = [
        //
    ];

    /**
     * A list of the inputs that are never flashed to the session on validation exceptions.
     *
     * @var array<int, string>
     */
    protected $dontFlash = [
        'current_password',
        'password',
        'password_confirmation',
    ];

    /**
     * Register the exception handling callbacks for the application.
     */
    public function register(): void
    {
        //
    }
    public function render($request, Throwable $e)
    {
        if ($request->is('api/*')) {
            if ($e instanceof ResponseValidationException){
                return response()->json([
                    'status' => "error",
                    'mensaje_error' => $e->getMessage()
                ], 400);
            }
            if($e instanceof TokenException){
                return parent::render($request, $e);
            }
            Log::error($e);
                return (new JsonErrorResponse($e->getMessage(), 400))->send();
            };
            if ($e instanceof AuthorizationException) {
                return response()->json([
                    'error' => 'Access denied. You dont have permission to perform this action.'
                ], 403);
            }
            
        return parent::render($request, $e);
    }
    public function report(Exception|Throwable $exception)
    {
        if (
            !($exception instanceof \Symfony\Component\HttpKernel\Exception\HttpException) 
            && !($exception instanceof TokenException)
            && !($exception instanceof ResponseValidationException)
        ) {
            parent::report($exception);
        }
    }
    private function transformErrors(ValidationException $exception)
    {
        $errors = $exception->errors();
        $concatenatedErrors = "";
        $concatenatedErrors = array_map(function ($error) {
            return $error[0]; 
        }, $errors);
    
        $concatenatedErrorsString = implode(" ", $concatenatedErrors);
    
        return $concatenatedErrorsString;
    }
}
