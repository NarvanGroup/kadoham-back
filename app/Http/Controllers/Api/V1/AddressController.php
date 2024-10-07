<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\V1\Address\StoreAddressRequest;
use App\Http\Resources\Api\V1\Address\AddressResource;
use App\Models\Api\V1\Address;
use App\Models\Api\V1\User;
use App\Notifications\OtpNotification;
use App\Notifications\WelcomeNotification;
use App\Services\Api\V1\AddressService;
use App\Traits\Api\V1\ResponderTrait;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Modules\Inquiry\App\Services\Ehraz\EhrazService;
use Modules\Payment\App\Merchants\Novinpal;
use Modules\Payment\App\Service\PaymentService;

class AddressController extends Controller
{
    use ResponderTrait;

    public function __construct(
        private readonly AddressService $addressService
    ) {
    }

    public function index()
    {
/*        $user = User::first();
        $user->notify(new WelcomeNotification());
        dd($user->notifications);

        $mobile = '09190755375';

        $user->notify(new WelcomeNotification());
        dd('ok!');
        $card = '6274121199004409';
        $amount = 990000000;
        $orderId = mt_rand(1000000,999999999);
        $description = 'Novinpal is the best';
        return (new PaymentService())->pay($user, $amount, $orderId, $mobile, $card, $description);

        $jibit = new EhrazService();
        dd($jibit->convertCardToIban(6274121199004409));*/
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

    public function verify(Request $request)
    {
        info($request->refId);
        info(Route::current()->parameters());
        $payment = new PaymentService();
        $payment->verify($request->refId);
    }

}
