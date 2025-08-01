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
        $dto = new UserDTO($request->validated());
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


    public function destroy(User $user)
    {
        $user->delete();
        return ResponseHelper::success(null, 'User deleted');
    }

}
