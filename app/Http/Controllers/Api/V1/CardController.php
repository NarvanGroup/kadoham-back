<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\V1\Cards\StoreCardRequest;
use App\Http\Resources\Api\V1\Card\CardResource;
use App\Models\Api\V1\Card;
use App\Services\Api\V1\BankService;
use App\Traits\Api\V1\ResponderTrait;
use Illuminate\Http\JsonResponse;

class CardController extends Controller
{
    use ResponderTrait;

    public function index(): JsonResponse
    {
        return $this->responseIndex(CardResource::collection(auth()->user()->cards()->get()));
    }

    public function store(StoreCardRequest $request): JsonResponse
    {
        return $this->responseCreated(new CardResource(auth()->user()->cards()->create($request->validated())));
    }

    public function show(Card $card): JsonResponse
    {
        $this->authorize('show', $card);
        return $this->responseShow(new CardResource($card));

    }

    public function update(StoreCardRequest $request, Card $card): JsonResponse
    {
        $this->authorize('update', $card);
        $card->update($request->validated());
        return $this->responseUpdated($card->fresh());
    }

    public function destroy(Card $card): JsonResponse
    {
        $this->authorize('destroy', $card);
        $card->delete();
        return $this->responseDestroyed();
    }
}
