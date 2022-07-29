<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Laravel\Socialite\Facades\Socialite;
use RealRashid\SweetAlert\Facades\Alert;

class LoginSocialiteController extends Controller
{
    protected $providers = [
        'github',
        'google',
    ];

    private function isProviderAllowed(string $driver)
    {
        return in_array($driver, $this->providers) && config()->has("services.{$driver}");
    }

    public function google(string $driver)
    {
        // dd(session('lastActivityTime'));
        if (!$this->isProviderAllowed($driver)) {
            return view(abort(404));
        }

        try {
            return Socialite::driver($driver)->redirect();
        } catch (Exception $e) {
            return view(abort(404));
        }
    }

    public function handleGoogleCallback(string $driver)
    {
        try {
            $callback = Socialite::driver($driver)->stateless()->user();
            $piece = explode(" ", $callback->getName());
            // dd($piece);

            match ($driver) {
                'google' => $data = [
                    'firstname' => $callback->offsetGet('given_name'),
                    'lastname' => $callback->offsetGet('family_name'),
                    'email' => $callback->getEmail(),
                    'avatar' => $callback->getAvatar(),
                    'provider_name' => $driver,
                    'provider_id' => $callback->getId(),
                    'email_verified_at' => date('Y-m-d H:i:s'),
                ],

                'github' => $data = [
                    'firstname' => $piece[0],
                    'lastname' => $piece[1],
                    'email' => $callback->getEmail(),
                    'username' => $callback->getNickname(),
                    'avatar' => $callback->getAvatar(),
                    'provider_name' => $driver,
                    'provider_id' => $callback->getId(),
                    'email_verified_at' => date('Y-m-d H:i:s'),
                ],

                default => view(abort(404)),
            };

            // switch ($driver) {

            //     case 'google':
            //         $data = [
            //             'firstname' => $callback->offsetGet('given_name'),
            //             'lastname' => $callback->offsetGet('family_name'),
            //             'email' => $callback->getEmail(),
            //             'avatar' => $callback->getAvatar(),
            //             'provider_name' => $driver,
            //             'provider_id' => $callback->getId(),
            //             'email_verified_at' => date('Y-m-d H:i:s'),
            //         ];
            //         break;

            //     case 'github':
            //         $data = [
            //             'firstname' => $piece[0],
            //             'lastname' => $piece[1],
            //             'email' => $callback->getEmail(),
            //             'username' => $callback->getNickname(),
            //             'avatar' => $callback->getAvatar(),
            //             'provider_name' => $driver,
            //             'provider_id' => $callback->getId(),
            //             'email_verified_at' => date('Y-m-d H:i:s'),
            //         ];
            //         break;
            // }

            $user = User::firstOrCreate(['email' => $data['email']], $data);
            Auth::login($user, true);

            return to_route('home.index')->with('toast_success', 'Welcome ' . Auth::user()->firstname);
        } catch (Exception $e) {
            return view(abort(404));
        }
    }
}
