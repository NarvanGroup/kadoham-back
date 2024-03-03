<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\V1\Address\StoreAddressRequest;
use App\Http\Resources\Api\V1\Address\AddressResource;
use App\Models\Api\V1\Address;
use App\Services\Api\V1\AddressService;
use App\Traits\Api\V1\ResponderTrait;
use Illuminate\Http\JsonResponse;

class AddressController extends Controller
{
    use ResponderTrait;

    public function __construct(
        private readonly AddressService $addressService
    ) {
    }

    public function index(): JsonResponse
    {
        return $this->responseIndex(AddressResource::collection(auth()->user()->addresses()->get()));
    }

    public function store(StoreAddressRequest $request): JsonResponse
    {
        return $this->responseCreated(new AddressResource(auth()->user()->addresses()->create($request->validated())));
    }

    public function show(Address $address): JsonResponse
    {
        $this->authorize('show', $address);
        return $this->responseShow($address);
    }

    public function update(StoreAddressRequest $request, Address $address): JsonResponse
    {
        $this->authorize('update', $address);
        $address->update($request->validated());
        return $this->responseUpdated($address->fresh());
    }

    public function destroy(Address $address): JsonResponse
    {
        $this->authorize('destroy', $address);
        $address->delete();
        return $this->responseDestroyed();
    }

    public function getProvinces(): JsonResponse
    {
        return $this->addressService->getAllProvinces();
    }

    public function getCities(int $provinceId): JsonResponse
    {
        return $this->addressService->getCities($provinceId);
    }

}
