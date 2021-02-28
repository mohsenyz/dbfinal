<?php

namespace App\Http\Controllers;

use App\Models\Employee;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Http\JsonResponse;
use Illuminate\Routing\Controller as BaseController;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    protected function respondSuccess(): JsonResponse
    {
        return response()->json(['status' => 200], 200);
    }

    protected function respondSuccessWithModel(?Model $model): JsonResponse
    {
        return response()->json(['status' => 200, 'key' => optional($model)->getKey()], 200);
    }

    protected function respondBadRequest($options): JsonResponse
    {
        return response()->json(array_merge(['status' => 400], $options), 400);
    }

    protected function respondNotFound($options): JsonResponse
    {
        return response()->json(array_merge(['status' => 404], $options), 404);
    }


    protected function currentEmployee(): Employee
    {
        return auth()->user();
    }
}
