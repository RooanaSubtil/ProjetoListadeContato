<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Http\JsonResponse;
use Illuminate\Routing\Controller as BaseController;
use Symfony\Component\HttpFoundation\Response;
class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    /**
     * @param mixed $response
     * @param int $status
     * @return JsonResponse
     */
    protected function formatResponse(Response $response, int $status = Response::HTTP_OK): JsonResponse
    {
        return response()->json(array_filter((array) $response, function ($var) {
            return !is_null($var);
        }), $status);
    }
}
