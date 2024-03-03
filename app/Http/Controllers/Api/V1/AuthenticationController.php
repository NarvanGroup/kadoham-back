<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\V1\Authentication\AuthenticationRequest;
use App\Http\Requests\Api\V1\Authentication\OtpLoginRequest;
use App\Http\Requests\Api\V1\Authentication\OtpRequest;
use App\Http\Requests\Api\V1\Authentication\PasswordLoginRequest;
use App\Http\Resources\Api\V1\Chart\ChartResource;
use App\Http\Resources\Api\V1\User\UserResource;
use App\Models\Api\V1\Authentication;
use App\Models\Api\V1\Chart;
use App\Models\Api\V1\User;
use App\Repositories\Api\V1\User\UserRepository;
use App\Traits\Api\V1\ResponderTrait;
use Carbon\Carbon;
use DateTime;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Hash;


class AuthenticationController extends Controller
{
    use ResponderTrait;

    public function __construct(private readonly UserRepository $userRepository)
    {
    }

    /**
     * Login api
     *
     * @return JsonResponse
     */
    public function loginOtp(OtpLoginRequest $request)
    {
        $user = User::where('mobile', $request->mobile)->first();

        if (!$user || $user->otp === null || !Hash::check($request->otp, $user->otp)) {
            return $this->responseForbidden('Unauthorised.');
        }

        $user->update(['otp' => null]);

        $token = $user->createToken($request->header('user-agent'),['*'], now()->addWeek()->toDateTime())->plainTextToken;

        $userData = new UserResource($user);

        return $this->response([
            'token' => $token,
            'user' => $userData,
        ]);
    }

    /**
     * Login api
     *
     * @return JsonResponse
     */
    public function loginPassword(PasswordLoginRequest $request)
    {
        $user = User::where('mobile', $request->mobile)->first();

        if (!$user || $user->password === null || !Hash::check($request->password, $user->password)) {
            return $this->respondForbidden('Unauthorised.');
        }

        $token = $user->createToken($request->header('user-agent'),['*'], Carbon::now()->toDateTime())->plainTextToken;
        $userData = new UserResource($user);

        return $this->response([
            'token' => $token,
            'user' => $userData,
        ]);
    }

    public function sendOtp(OtpRequest $request)
    {
        $otp = random_int(10000, 99999);
        $user = User::query()->updateOrCreate(['mobile' => $request->mobile], ['otp' => Hash::make($otp)]);
        //(new SmsChannel())->setReceiver($user->mobile)->setOtp($otp)->send();

        return $this->responseSuccessful($otp);
    }

    public function authentication(AuthenticationRequest $request)
    {
        $user = $request->user();

        if ($user->hasPendingAuthentication()) {
            return $this->respondError('شما یک احراز هویت در انتظار تایید دارید!');
        }

        $authentication = new Authentication([
            ['type' => 'KYC'],
            ['status' => 'PENDING']
        ]);

        // Store the uploaded image file in a storage location
        $image = $request->file('image');
        $imageName = uniqid('nid_', true) . '.' . $image->getClientOriginalExtension();
        $image->storeAs('public/images', $imageName);

        // Return a response with the URL of the uploaded image
        $imageUrl = asset('storage/images/' . $imageName);


        $user->update([
            ...$request->except('image'),
            'image' => $imageUrl
        ]);
        $user->authentications()->save($authentication);

        return $this->responseSuccessful();
    }

    /**
     * Login api
     *
     * @return JsonResponse
     */
    public function userInquiry(OtpRequest $request)
    {
        $user = $this->userRepository->where('mobile', '=', $request->mobile)->first();
        return $this->response([
            'isNewUser' => $user === null,
            'hasPassword' => $user !== null && $user->password !== null,
        ]);
    }
}
