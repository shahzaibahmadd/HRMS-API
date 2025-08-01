<?php
namespace App\Http\Middleware;

use App\Services\ErrorLogging\ErrorLoggingService;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;
use App\Models\User;

class RoleMiddleware
{
    public function handle(Request $request, Closure $next): Response
    {
        try {
            if (!Auth::check()) {
                return response()->json([
                    'status' => false,
                    'message' => 'Unauthenticated.'
                ], 401);
            }

            $user = Auth::user();
            $targetUser = $request->route('user');


            if ($targetUser && $targetUser instanceof User) {
                if ($user->hasRole('Admin') && $user->can('view all dashboards')) {
                    return $next($request);
                }

                if ($user->hasRole('HR') && $user->can('view hr and below dashboards')) {
                    if (
                        ($targetUser->hasRole('HR') && $user->id === $targetUser->id) ||
                        $targetUser->hasRole('Manager') ||
                        $targetUser->hasRole('Employee')
                    ) {
                        return $next($request);
                    }
                }

                if ($user->hasRole('Manager') && $user->can('view manager and below dashboards')) {
                    if (
                        ($targetUser->hasRole('Manager') && $user->id === $targetUser->id) ||
                        $targetUser->hasRole('Employee')
                    ) {
                        return $next($request);
                    }
                }

                if ($user->hasRole('Employee') && $user->can('view own dashboard')) {
                    if ($user->id === $targetUser->id) {
                        return $next($request);
                    }
                }

                return response()->json([
                    'status' => false,
                    'message' => 'Unauthorized access.'.$user,
                ], 403);
            }


            return $this->checkPermissionOnly($user, $next, $request);

        } catch (\Throwable $e) {
            ErrorLoggingService::log($e);

            return response()->json([
                'status' => false,
                'message' => 'Something went wrong.',
                'User Info'=>'Role: ' . $user->getRoleNames()->first(). 'User ID:' . $user->id
            ], 500);
        }
    }

    private function checkPermissionOnly($user, Closure $next, Request $request)
    {
        if (
            ($user->hasRole('Admin') && $user->can('view all dashboards')) ||
            ($user->hasRole('HR') && $user->can('view hr and below dashboards')) ||
            ($user->hasRole('Manager') && $user->can('view manager and below dashboards')) ||
            ($user->hasRole('Employee') && $user->can('view own dashboard'))
        ) {
            return $next($request);
        }
//
//        return response()->json([
//            'status' => false,
//            'message' => 'Unauthorized access.',
//            'User Info'=>'Role: ' . $user->getRoleNames()->first(). 'User ID:' . $user->id
//        ], 403);
        return $next($request);
    }
}
