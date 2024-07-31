<?php

namespace App\Http\Controllers\Api\V1;

use App\Helper\UploadHelper;
use App\Http\Controllers\Controller;
use App\Http\Requests\Api\V1\ThankYouNote\StoreThankYouNoteRequest;
use App\Http\Resources\Api\V1\ThankYouNote\ThankYouNoteResource;
use App\Models\Api\V1\ThankYouNote;
use App\Traits\Api\V1\ResponderTrait;
use Illuminate\Http\JsonResponse;

class ThankYouNoteController extends Controller
{
    use ResponderTrait;

    public function index(): JsonResponse

    {
        return $this->responseIndex(auth()->user()->thankYouNotes()->get());
    }

    public function store(StoreThankYouNoteRequest $request): JsonResponse
    {
        $data = $request->validated();
        $data['file'] = UploadHelper::upload($request,'file','thank-you/'.strtolower($data['type']));
        return $this->responseCreated(new ThankYouNoteResource(auth()->user()->thankYouNotes()->create($data)));
    }

    public function show(ThankYouNote $thankYouNote): JsonResponse
    {
        $this->authorize('show', $thankYouNote);
        return $this->responseShow(new ThankYouNoteResource($thankYouNote));
    }

    public function update(StoreThankYouNoteRequest $request, ThankYouNote $thankYouNote): JsonResponse
    {
        $this->authorize('update', $thankYouNote);
        $data = $request->validated();
        $data['file'] = UploadHelper::upload($request,'file','thank-you/'.strtolower($data['type']));
        $thankYouNote->update($data);
        return $this->responseUpdated($thankYouNote->fresh());
    }

    public function destroy(ThankYouNote $thankYouNote): JsonResponse
    {
        $this->authorize('destroy', $thankYouNote);
        $thankYouNote->delete();
        return $this->responseDestroyed();
    }
}
