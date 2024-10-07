<?php

namespace App\Http\Controllers\Api\V1;

use App\Helper\UploadHelper;
use App\Http\Controllers\Controller;
use App\Http\Requests\Api\V1\User\ResetPasswordRequest;
use App\Http\Requests\Api\V1\User\SearchRequest;
use App\Http\Requests\Api\V1\User\SyncInterestRequest;
use App\Http\Requests\Api\V1\User\UpdateProfileRequest;
use App\Http\Resources\Api\V1\Notification\NotificationResource;
use App\Http\Resources\Api\V1\User\UserResource;
use App\Models\Api\V1\User;
use App\Repositories\Api\V1\User\UserRepository;
use App\Traits\Api\V1\ResponderTrait;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Symfony\Component\BrowserKit\Client;

class UserController extends Controller
{
    use ResponderTrait;

    public function __construct(
        private readonly UserRepository $userRepository
    ) {
    }

    public function index(): JsonResponse
    {
        return $this->responseIndex($this->userRepository->all());
    }

    public function store(Request $request): JsonResponse
    {
        return $this->responseCreated($this->userRepository->create($request->all()));
    }

    public function show(User $user): JsonResponse
    {
        return $this->responseShow($this->userRepository->find($user->id));
    }

    public function update(UpdateProfileRequest $request): JsonResponse
    {
        $data = $request->validated();
        $user = auth()->user();
        $data['image'] = UploadHelper::upload($request, 'image', 'avatars');
        $user->update($data);
        return $this->responseUpdated(new UserResource($user->fresh()));
    }

    public function destroy(User $user): JsonResponse
    {
        $this->userRepository->delete($user->id);
        return $this->responseDestroyed();
    }

    public function profile(): JsonResponse
    {
        return $this->response(new UserResource(auth()->user()->load('interests', 'addresses', 'cards', 'socialMedia', 'itemBuyer', 'wallet')));
    }

    public function logout(): JsonResponse
    {
        auth()->user()->currentAccessToken()->delete();
        return $this->responseSuccessful('Longed out successfully');
    }

    public function resetPassword(ResetPasswordRequest $request): JsonResponse
    {
        auth()->user()->update(['password' => Hash::make($request->new_password)]);
        return $this->responseSuccessful('کلمه عبور با موفقیت آپدیت شد');
    }

    public function forgotPassword(): JsonResponse
    {
        return $this->response(new UserResource(auth()->user()->load('addresses', 'cards', 'wallets')));
    }

    public function publicProfile(string $username): JsonResponse
    {
        $user = User::where('username', $username)->firstOrFail();
        return $this->response(new UserResource($user->load('wishLists.items')));
    }

    public function syncInterests(SyncInterestRequest $request): JsonResponse
    {
        $user = auth()->user();
        $user->interests()->updateOrCreate(['user_id' => $user->id], $request->validated());
        return $this->response(new UserResource($user->load('interests')));
    }

    public function search(SearchRequest $request)
    {
        $search = $request->search;

        $users = User::search($search)->orWhereHas('wishLists', function ($query) use ($search) {
            $query->public()->search($search);
        })->with(['socialMedia'])->get()->load([
                'socialMedia',
                'wishLists' => function ($query) {
                    $query->public();
                }
            ]);

        return UserResource::collection($users);
    }

    public function purchases(): JsonResponse
    {
        return $this->response(new UserResource(auth()->user()->load('itemBuyer.item.wishList')));
    }

    public function notifications(): JsonResponse
    {
        return $this->response(NotificationResource::collection(auth()->user()->notifications));
    }

    public function unreadNotifications(): JsonResponse
    {
        return $this->response(NotificationResource::collection(auth()->user()->unreadNotifications));
    }

    public function markAsReadNotification(string $notificationId): JsonResponse
    {
        auth()->user()->notifications()->findOrFail($notificationId)->update(['read_at' => now()]);
        return $this->responseSuccessful('عملیات با موفقیت انجام شد');
    }

    public function markAsUnreadNotification(string $notificationId): JsonResponse
    {
        auth()->user()->notifications()->findOrFail($notificationId)->update(['read_at' => null]);
        return $this->responseSuccessful('عملیات با موفقیت انجام شد');
    }

    public function markAsReadAllNotifications(): JsonResponse
    {
        auth()->user()->unreadNotifications->markAsRead();
        return $this->responseSuccessful('عملیات با موفقیت انجام شد');
    }
    public function markAsUnreadAllNotifications(): JsonResponse
    {
        auth()->user()->unreadNotifications->markAsUnread();
        return $this->responseSuccessful('عملیات با موفقیت انجام شد');
    }
}
