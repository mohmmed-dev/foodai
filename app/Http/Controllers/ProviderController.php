<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Laravel\Socialite\Socialite;

class ProviderController extends Controller
{
     protected  $providers = ['google'];

    public function ProviderRedirect(String $provider ) {
        if(!in_array($provider,$this->providers)) {
            return redirect()->route('login');
        }
        try {
            return Socialite::driver($provider)->redirect();
        } catch(\Exception $e) {
            return redirect()->route('login');
        }
    }

    public function ProviderCallback(String $provider) {
        if(!in_array($provider,$this->providers)) {
            return redirect()->route('login');
        }
        try {
            $socialUser = Socialite::driver($provider)->user();
        } catch(\Exception $e) {
            return redirect()->route('login');
        }

        $name = $socialUser->name;
        $user = User::firstOrCreate([
            'provider_id' => $socialUser->id,
            'provider_name' => $provider,
        ], [
            'name' => $name,
            'email' => $socialUser->email,
        ]);

        $user->update([
            'Provider_token' => $socialUser->token,
            'Provider_refresh_token' => $socialUser->refreshToken,
        ]);

        Auth::login($user , true);

        return redirect()->route('home');
    }
}
