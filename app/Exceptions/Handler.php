<?php

namespace App\Exceptions;

use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Throwable;
use Mockery\Exception;
use Symfony\Component\HttpKernel\Exception\HttpException;
use Symfony\Component\HttpKernel\Exception\AccessDeniedHttpException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\HttpKernel\Exception\MethodNotAllowedHttpException;
use Symfony\Component\HttpKernel\Exception\TooManyRequestsHttpException;
use Symfony\Component\ErrorHandler\Error\FatalError;
use Symfony\Component\ErrorHandler\Error\ClassNotFoundError;
use Illuminate\Database\QueryException;
use Illuminate\Database\RecordsNotFoundException;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Database\Eloquent\RelationNotFoundException;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Http\Exceptions\PostTooLargeException;
use Illuminate\Http\Exceptions\ThrottleRequestsException;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Validation\ValidationException;
use BadMethodCallException;

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
        $this->reportable(function (Throwable $e) {
            //
        });

        $this->renderable(function (NotFoundHttpException $e, $request) {
            if ($request->is('api/*')) {
                return response()->json([
                    'code' => $e->getCode(),
                    'message' => $e->getMessage(),
                ], $e->getStatusCode());
            }
        });

        $this->renderable(function (AccessDeniedHttpException $e, $request) {
            if ($request->is('api/*')) {
                return response()->json([
                    'code' => $e->getCode(),
                    'message' => $e->getMessage(),
                ], $e->getStatusCode());
            }
        });

        $this->renderable(function (QueryException $e, $request) {
            if ($request->is('api/*')) {
                return response()->json([
                    'code' => $e->getCode(),
                    'message' => $e->getMessage(),
                ], 491);
            }
        });

        $this->renderable(function (RecordsNotFoundException $e, $request) {
            if ($request->is('api/*')) {
                return response()->json([
                    'code' => $e->getCode(),
                    'message' => $e->getMessage(),
                ], 491);
            }
        });

        $this->renderable(function (RelationNotFoundException $e, $request) {
            if ($request->is('api/*')) {
                return response()->json([
                    'code' => $e->getCode(),
                    'message' => $e->getMessage(),
                ], 491);
            }
        });

        $this->renderable(function (MethodNotAllowedHttpException $e, $request) {
            if ($request->is('api/*')) {
                return response()->json([
                    'code' => $e->getCode(),
                    'message' => $e->getMessage(),
                ], $e->getStatusCode());
            }
        });

        $this->renderable(function (TooManyRequestsHttpException $e, $request) {
            if ($request->is('api/*')) {
                return response()->json([
                    'code' => $e->getCode(),
                    'message' => $e->getMessage(),
                ], $e->getStatusCode());
            }
        });

        $this->renderable(function (Exception $e, $request) {
            if ($request->is('api/*')) {
                return response()->json([
                    'code' => $e->getCode(),
                    'message' => $e->getMessage(),
                ], 500);
            }
        });

        $this->renderable(function (HttpException $e) {
            return response()->json([
                'code' => $e->getCode(),
                'message' => $e->getMessage(),
            ], $e->getStatusCode());
        });

        $this->renderable(function (AuthenticationException $e) {
            return response()->json([
                'code' => $e->getCode(),
                'message' => $e->getMessage(),
            ], 401);
        });

        $this->renderable(function (ModelNotFoundException $e) {
            return response()->json([
                'code' => $e->getCode(),
                'message' => $e->getModel()." not found",
            ], 404);
        });

        $this->renderable(function (ClassNotFoundError $e) {
            return response()->json([
                'code' => $e->getCode(),
                'message' => $e->getMessage(),
            ], 404);
        });

        $this->renderable(function (ValidationException $e) {
            return response()->json([
                'code' => $e->getCode(),
                'message' => $e->getMessage(),
            ], 422);
        });

        $this->renderable(function (HttpResponseException $e) {
            return response()->json([
                'code' => $e->getCode(),
                'message' => $e->getMessage(),
            ], 422);
        });

        $this->renderable(function (PostTooLargeException $e) {
            return response()->json([
                'code' => $e->getCode(),
                'message' => $e->getMessage(),
            ], $e->getStatusCode());
        });

        $this->renderable(function (ThrottleRequestsException $e) {
            return response()->json([
                'code' => $e->getCode(),
                'message' => $e->getMessage(),
            ], $e->getStatusCode());
        });

        $this->renderable(function (BadMethodCallException $e) {
            return response()->json([
                'code' => $e->getCode(),
                'message' => $e->getMessage(),
            ], 500);
        });

        $this->renderable(function (FatalError $e, $request) {
            if ($request->is('api/*')) {
                return response()->json([
                    'code' => $e->getCode(),
                    'message' => $e->getMessage(),
                ], 500);
            }
        });
    }
}
