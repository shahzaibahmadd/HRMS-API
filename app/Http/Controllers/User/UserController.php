<?php

namespace App\Http\Controllers\User;

use App\DTOs\User\UserDTO;
use App\Helpers\ResponseHelper;
use App\Http\Controllers\Controller;
use App\Http\Requests\User\RegisterRequest;
use App\Http\Requests\User\StoreUserRequest;
use App\Http\Requests\User\UpdateUserRequest;
use App\Http\Resources\User\UserResource;
use App\Models\User;
use App\services\User\UserService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    public function __construct(protected UserService $userService) {}

    public function store(StoreUserRequest $request)
    {
      $dto = new UserDTO($request->validated());

        $user = $this->userService->create($dto);
        return ResponseHelper::success(new UserResource($user), 'User created');
    }

    public function update(UpdateUserRequest $request, User $user)
    {
        $authUser = auth()->user();

        if ($authUser->id === $user->id) {
            return ResponseHelper::error('You cannot update yourself.', 403);
        }

        if ($authUser->hasRole('Admin') && $user->hasRole('Admin')) {
            return ResponseHelper::error('Admins cannot update other Admins.', 403);
        }
        $dto = new UserDTO($request,$user);
        $updated = $this->userService->update($user, $dto);
        return ResponseHelper::success(new UserResource($updated), 'User updated');
    }

//    public function index()
//    {
//        $users = User::with('roles')->get();
//        return ResponseHelper::success(UserResource::collection($users));
//    }
    public function index(Request $request)
    {
        $users = $this->userService->listWithFilters($request);

        return ResponseHelper::success(
            UserResource::collection($users)->response()->getData(true),
            'Users fetched successfully.'
        );
    }


    public function destroy($id)
    {
        // Get user including soft-deleted ones
        $user = User::withTrashed()->find($id);

        if (!$user) {
            return ResponseHelper::error('User does not exist.', 404);
        }

        if ($user->trashed()) {
            return ResponseHelper::error('User is already deleted.', 400);
        }

        $authUser = auth()->user();

        if ($authUser->id === $user->id) {
            return ResponseHelper::error('You cannot delete yourself.', 403);
        }

        if ($authUser->hasRole('Admin') && $user->hasRole('Admin')) {
            return ResponseHelper::error('Admins cannot delete other Admins.', 403);
        }

        $user->delete();

        return ResponseHelper::success(null, 'User deleted.');
    }

    public function deletedUsers(Request $request)
    {
        $users = $this->userService->listDeletedUsers($request);

        return ResponseHelper::success(
            UserResource::collection($users)->response()->getData(true),
            'Deleted users fetched successfully.'
        );
    }

    public function restore($id)
    {
        $user = User::withTrashed()->findOrFail($id);

        if (!$user->trashed()) {

            return ResponseHelper::error( 'User is already active.');
        }

        $user->restore();

        return ResponseHelper::success( 'User restored');
    }

}
