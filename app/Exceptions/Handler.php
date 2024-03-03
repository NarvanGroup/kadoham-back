<?php

namespace App\Exceptions;

use App\Traits\Api\V1\ResponderTrait;
use Exception;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Illuminate\Http\JsonResponse;
use Throwable;

class Handler extends ExceptionHandler
{
    use ResponderTrait;
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
     * Write code on Method
     *
     * @return JsonResponse()
     */
/*    public function render($request, Exception|Throwable $e)
    {
        if ($e instanceof ModelNotFoundException) {
            return response()->json([
                'success' => false,
                'message' => trans('response.not_found'),
            ], 404);
        }

        dd($e);
        return response()->json([
            'success' => false,
            'message' => $e->getMessage(),
        ], 500);
    }*/
}
