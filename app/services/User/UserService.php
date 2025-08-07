<?php

namespace App\services\User;

use App\DTOs\User\UserDTO;
use App\Filters\User\UserFilter;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Pipeline\Pipeline;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;

class UserService
{
    public function create(UserDTO $dto): User
    {
        return DB::transaction(function () use ($dto) {
            $data = $dto->toArray();

            $data['password'] = Hash::make($dto->password);


            $user = User::create($data);
            $user->assignRole($dto->role);

            return $user;
        });
    }

    public function update(User $user, UserDTO $dto): User
    {
        $data = $dto->toArray();

        if ($dto->password) {
            $data['password'] = Hash::make($dto->password);
        } else {
            unset($data['password']);
        }

        $user->update($data);

        if ($dto->role && !$user->hasRole($dto->role)) {
            $user->syncRoles([$dto->role]);
        }

        return $user;
    }


    public function listWithFilters(Request $request)
    {
        $query = User::query()->with('roles');


        $query = app(Pipeline::class)
            ->send($query)
            ->through([
                fn($query) => (new UserFilter($request))->apply($query),
            ])
            ->thenReturn();

        $perPage = $request->input('per_page', 10);
        return $query->paginate($perPage);
    }
    public function listDeletedUsers(Request $request)
    {
        $query = User::onlyTrashed()->with('roles');

        $query = app(Pipeline::class)
            ->send($query)
            ->through([
                fn($query) => (new UserFilter($request))->apply($query),
            ])
            ->thenReturn();

        $perPage = $request->input('per_page', 10);
        return $query->paginate($perPage);
    }

}
