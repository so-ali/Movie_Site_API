<?php

namespace App\Exceptions;

use Exception;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Database\QueryException;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Illuminate\Validation\ValidationException;
use Symfony\Component\HttpFoundation\Exception\BadRequestException;
use Symfony\Component\HttpKernel\Exception\HttpException;
use Symfony\Component\HttpKernel\Exception\MethodNotAllowedHttpException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Throwable;

class Handler extends ExceptionHandler
{
    /**
     * The list of the inputs that are never flashed to the session on validation exceptions.
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
        //TODO Should be Customise messages.
        if (env('APP_ENV') !=='local'){
            $this->renderable(function (Throwable $exception) {
                if($exception instanceof QueryException){
                    return response()->json([
                        'message'     => 'QueryException',
                        'serverError' => $exception->getMessage(),
                    ], 404);
                }
                if ($exception instanceof NotFoundHttpException) {
                    return response()->json([
                        'message'     => 'NotFoundHttpException',
                        'serverError' => $exception->getMessage(),
                    ], 404);
                }
                if ($exception instanceof HttpException) {
                    return response()->json([
                        'message'     => 'HttpException',
                        'serverError' => $exception->getMessage(),
                    ], 500);
                }
                if ($exception instanceof ModelNotFoundException) {
                    return response()->json([
                        'message'     => 'ModelNotFoundException',
                        'serverError' => $exception->getMessage(),
                    ], 404);
                }
                if ($exception instanceof ValidationException) {
                    return response()->json([
                        'message' => 'ValidationException',
                        'errors'  => $exception->validator->errors(),
                    ], 403);
                }
                if ($exception instanceof AuthenticationException) {
                    return response()->json([
                        'message'     => 'AuthenticationException',
                        'serverError' => $exception->getMessage(),
                    ], 401);
                }
                if ($exception instanceof \Error) {
                    return response()->json([
                        'message'     => 'Error',
                        'serverError' => $exception->getMessage(),
                    ], 500);
                }
                if ($exception instanceof BadRequestException) {
                    return response()->json([
                        'message'     => 'BadRequestException',
                        'serverError' => $exception->getMessage(),
                    ], 400);
                }
                try {
                    return response()->json(
                        [
                            'message'     => get_class($exception),
                            'serverError' => null,
                        ],
                        500
                    );
                } catch (Exception $e) {
                    return response()->json(
                        [
                            'message'     => 'UnknownError',
                            'serverError' => $e->getMessage(),
                        ],
                        500
                    );
                }
            });
        }
    }
}
