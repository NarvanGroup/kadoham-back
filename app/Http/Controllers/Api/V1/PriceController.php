<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\V1\Price\GetPriceRequest;
use App\Services\Api\V1\PriceService;
use App\Traits\Api\V1\ResponderTrait;
use Illuminate\Http\JsonResponse;

class PriceController extends Controller
{
    use ResponderTrait;

    public function getPrice(GetPriceRequest $request): JsonResponse
    {
        $result = (new PriceService($request->validated('url')))->getPrice();
        return $this->response($result);
    }
}
