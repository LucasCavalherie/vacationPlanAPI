<?php

namespace App\Exceptions;

use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Response;
use Illuminate\Validation\ValidationException;
use Symfony\Component\HttpFoundation\Response as ResponseStatus;
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
        $this->reportable(function (Throwable $e) {
            //
        });
    }

    /**
     * @param $request
     * @param Throwable $e
     * @return Response|JsonResponse|RedirectResponse
     * @throws Throwable
     */
    public function render($request, Throwable $e): Response|JsonResponse|RedirectResponse
    {
        if ($e instanceof ModelNotFoundException) {
            return response()->json([
                'error' => 'Entry for '.str_replace('App\Models\\', '', $e->getModel()).' not found'
            ], ResponseStatus::HTTP_NOT_FOUND);
        }

        if ($e instanceof ValidationException) {
            return response()->json([
                'message' => 'Validation failed',
                'errors' => $e->errors()
            ], ResponseStatus::HTTP_UNPROCESSABLE_ENTITY);
        }

        return parent::render($request, $e);
    }

}
