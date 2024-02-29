<?php

namespace App\Http\Controllers;

use Cache;
use GuzzleHttp\Promise\PromiseInterface;
use Http;
use Illuminate\Http\Client\Response;
use Illuminate\Http\array;
use Illuminate\Http\Request;
use App\Models\WishList;


class SSOController extends Controller
{
    /**
     * @param  string  $endpoint
     * @param  array|null  $params
     * @return Response
     */
    private function sendRequest(string $endpoint, array|null $params = null): Response
    {
        return Http::acceptJson()->withToken(request()->bearerToken())->post(env('SSO_URL').$endpoint, $params);
    }

    /**
     * @param  Request  $request
     * @return array|mixed
     */
    public function loginOtp(Request $request): array
    {
        $response = $this->sendRequest('/api/v1/loginOtp', [
            'mobile' => $request->mobile,
            'otp'    => $request->otp
        ]);

        if (($response->ok() && $response->json(['success']) === true)) {
            Cache::put($response->json('data.token'), $response->json('data'), now()->addWeek());
        }

        return $response->json();
    }

    /**
     * @param  Request  $request
     * @return array
     */
    public function loginPassword(Request $request): array
    {
        $response = $this->sendRequest('/api/v1/loginPassword', [
            'mobile' => $request->mobile,
            'password'    => $request->password
        ]);
        if (($response->ok() && $response->json(['success']) === true)) {
	        Cache::put($response->json('data.token'), $response->json('data'), now()->addWeek());
        }

        return $response->json();
    }

    /**
     * @param  Request  $request
     * @return array
     */
    public function resetPassword(Request $request): array
    {
        $response = $this->sendRequest('/api/v1/users/resetPassword', [
            'current_password' => $request->current_password,
            'new_password'     => $request->new_password,
        ]);

        return $response->json();
    }

    /**
     * @param  Request  $request
     * @return array
     */
    public function sendOtp(Request $request): array
    {
        $response = $this->sendRequest('/api/v1/otp', [
            'mobile' => $request->mobile,
        ]);

        return $response->json();
    }

    /**
     * @return array
     */
    public function logout(): array
    {
        return $this->sendRequest('/api/v1/users/logout')->json();
    }

    /**
     * @return array
     */
    public function profile(): array
    {
        $profile = $this->sendRequest('/api/v1/users/profile')->json();
	    $profile['data']['wishlists'] = WishList::where('user_id',$profile['data']['mobile'])->get();
		return $profile;
    }

    public function update(Request $request): array
    {
        return Http::acceptJson()->withToken(request()->bearerToken())->put(env('SSO_URL').'/api/v1/users/profile', $request->all())->json();
    }
}
