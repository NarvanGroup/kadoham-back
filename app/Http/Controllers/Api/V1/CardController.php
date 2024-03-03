<?php

namespace App\Http\Controllers\Api\V1;

use App\Enums\BanksEnum;
use App\Http\Controllers\Controller;
use App\Http\Requests\Api\V1\Cards\StoreCardRequest;
use App\Http\Resources\Api\V1\Card\CardResource;
use App\Models\Api\V1\Card;
use App\Repositories\Api\V1\Card\CardRepository;
use App\Services\Api\V1\BankService;
use App\Traits\Api\V1\ResponderTrait;
use Illuminate\Http\JsonResponse;

class CardController extends Controller
{
    use ResponderTrait;

    public function __construct(
        private readonly CardRepository $cardRepository,
        private readonly BankService    $bankService
    )
    {
    }

    public function index(): JsonResponse
    {
        return $this->responseIndex(CardResource::collection($this->cardRepository->all()));
    }

    public function store(StoreCardRequest $request): JsonResponse
    {
        $bankName = $request->filled('card_number')
            ? $this->bankService->findBankNameByCard($request->card_number)
            : $this->bankService->findBankNameByIban($request->iban);

        return $this->responseCreated(new CardResource($this->cardRepository->create(
            [...$request->validated(), 'bank_name' => BanksEnum::tryFrom($bankName)->value])));
    }

    public function show(Card $card): JsonResponse
    {
        $this->authorize('show', $card);
        return $this->responseShow(new CardResource($this->cardRepository->find($card->id)));
    }

    public function update(StoreCardRequest $request, Card $card): JsonResponse
    {
        $this->authorize('update', $card);
        $this->cardRepository->update($request->validated(), $card->id);
        return $this->responseUpdated('');
    }

    public function destroy(Card $card): JsonResponse
    {
        $this->authorize('destroy', $card);
        $this->cardRepository->delete($card->id);
        return $this->responseDestroyed();
    }
}
