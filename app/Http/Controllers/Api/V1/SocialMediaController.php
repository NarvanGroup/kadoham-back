<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\V1\SocialMedia\StoreSocialMediaRequest;
use App\Http\Resources\Api\V1\SocialMedia\SocialMediaResource;
use App\Models\Api\V1\SocialMedia;
use App\Traits\Api\V1\ResponderTrait;
use Illuminate\Http\JsonResponse;

class SocialMediaController extends Controller
{
    use ResponderTrait;

    public function index(): JsonResponse
    {
        return $this->responseIndex(SocialMediaResource::collection(auth()->user()->socialMedia()->get()));
    }

    public function store(StoreSocialMediaRequest $request): JsonResponse
    {
        return $this->responseCreated(new SocialMediaResource(auth()->user()->socialMedia()->create($request->validated())));
    }

    public function show(SocialMedia $social_medium): JsonResponse
    {
        $this->authorize('show', $social_medium);
        return $this->responseShow($social_medium);
    }

    public function update(StoreSocialMediaRequest $request, SocialMedia $social_medium): JsonResponse
    {
        $this->authorize('update', $social_medium);
        $social_medium->update($request->validated());
        return $this->responseUpdated();
    }

    public function destroy(SocialMedia $social_medium): JsonResponse
    {
        $this->authorize('destroy', $social_medium);
        $social_medium->delete();
        return $this->responseDestroyed();
    }
}
