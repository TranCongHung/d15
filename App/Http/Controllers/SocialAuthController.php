<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Laravel\Socialite\Facades\Socialite;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class SocialAuthController extends Controller
{
    /**
     * Redirect to Facebook for authentication
     */
    public function redirectToFacebook()
    {
        return Socialite::driver('facebook')->redirect();
    }

    /**
     * Handle Facebook callback
     */
    public function handleFacebookCallback()
    {
        try {
            $socialUser = Socialite::driver('facebook')->user();

            $user = $this->findOrCreateUser($socialUser, 'facebook');

            Auth::login($user);

            return redirect()->route('home')->with('success', 'Đăng nhập bằng Facebook thành công!');
        } catch (\Exception $e) {
            return redirect()->route('home')->with('error', 'Đăng nhập Facebook thất bại. Vui lòng thử lại.');
        }
    }

    /**
     * Redirect to Google for authentication
     */
    public function redirectToGoogle()
    {
        return Socialite::driver('google')->redirect();
    }

    /**
     * Handle Google callback
     */
    public function handleGoogleCallback()
    {
        try {
            $socialUser = Socialite::driver('google')->user();

            $user = $this->findOrCreateUser($socialUser, 'google');

            Auth::login($user);

            return redirect()->route('home')->with('success', 'Đăng nhập bằng Google thành công!');
        } catch (\Exception $e) {
            return redirect()->route('home')->with('error', 'Đăng nhập Google thất bại. Vui lòng thử lại.');
        }
    }

    /**
     * Find or create user based on social provider data
     */
    private function findOrCreateUser($socialUser, $provider)
    {
        // Check if user already exists with this provider and provider_id
        $user = User::where('provider', $provider)
                   ->where('provider_id', $socialUser->getId())
                   ->first();

        if ($user) {
            // Update avatar if it has changed
            if ($socialUser->getAvatar() && $user->avatar !== $socialUser->getAvatar()) {
                $user->update(['avatar' => $socialUser->getAvatar()]);
            }
            return $user;
        }

        // Check if user exists with same email
        $user = User::where('email', $socialUser->getEmail())->first();

        if ($user) {
            // Link existing user with social account
            $user->update([
                'provider' => $provider,
                'provider_id' => $socialUser->getId(),
                'avatar' => $socialUser->getAvatar(),
            ]);
            return $user;
        }

        // Create new user
        return User::create([
            'name' => $socialUser->getName(),
            'email' => $socialUser->getEmail(),
            'provider' => $provider,
            'provider_id' => $socialUser->getId(),
            'avatar' => $socialUser->getAvatar(),
            'password' => Hash::make(Str::random(24)), // Random password for social users
            'role' => 'user', // Default role as requested
            'email_verified_at' => now(), // Auto-verify social logins
        ]);
    }
}
