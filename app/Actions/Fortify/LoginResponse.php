<?php

namespace App\Actions\Fortify;

use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Laravel\Fortify\Contracts\LoginResponse as LoginResponseContract;

class LoginResponse implements LoginResponseContract
{
    
    public function toResponse($request)
    {
        $redirect = $this->determineRedirectPath($request);

        return $request->wantsJson()
            ? new JsonResponse([], 204)
            : redirect()->intended($redirect);
    }

    private function determineRedirectPath(Request $request): string
    {
        $user = $request->user();

        if ($user?->hasRole(User::ROLE_ADMIN)) {
            return route('dashboard');
        }

        return route('home');
    }
}
