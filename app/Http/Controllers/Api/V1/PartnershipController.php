<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\V1\Partnership\StorePartnershipRequest;
use App\Http\Resources\Api\V1\Partnership\PartnershipResource;
use App\Models\Api\V1\Partnership;
use App\Traits\Api\V1\ResponderTrait;
use Illuminate\Http\JsonResponse;

class PartnershipController extends Controller
{
    use ResponderTrait;

    public function index(): JsonResponse
    {
        return $this->responseIndex(PartnershipResource::collection(Partnership::all()));
    }

    public function store(StorePartnershipRequest $request): JsonResponse
    {
        return $this->responseCreated(new PartnershipResource(Partnership::create($request->validated())));
    }

    public function show(Partnership $partnership): JsonResponse
    {
        return $this->responseShow(new PartnershipResource($partnership));
    }

    public function update(PartnershipResource $request, Partnership $partnership): JsonResponse
    {
        $data = $request->validated();
        $partnership->update($data);
        return $this->responseUpdated(new PartnershipResource($partnership->fresh()));
    }

    public function destroy(Partnership $partnership): JsonResponse
    {
        $partnership->delete();
        return $this->responseDestroyed();
    }
}
