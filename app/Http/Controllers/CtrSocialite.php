<?php

namespace App\Http\Controllers;

use App\Models\Utilisateur;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Laravel\Socialite\Facades\Socialite;

class CtrSocialite extends Controller
{
    public function redirectToGoogle(){
        return Socialite::driver('google')->redirect();
    }




    public function GoogleCallback()
    {
        try {
            $user = Socialite::driver('google')->user();
            $findUser = Utilisateur::where('google_id', $user->getId())->first();

            if (!$findUser) {
                $newUser = Utilisateur::create([
                    'nom' => $user->getName(),
                    'email' => $user->getEmail(),
                    'google_id' => $user->getId(),
                ]);
                Auth::login($newUser);
            } else {
                Auth::login($findUser);
            }

            return redirect()->route('Acceuil.index'); // Utilise la redirection avec la route nommée
        } catch (Exception $e) {
            dd($e->getMessage());
        }
    }

    public function redirectToFacebook(){
        return Socialite::driver('facebook')->redirect();
    }

    public function FacebookCallback(){
        try {
            $user = Socialite::driver('facebook')->user();
            $findUser = Utilisateur::where('facebook_id', $user->getId())->first();

            if (!$findUser) {
                $newUser = Utilisateur::create([
                    'nom' => $user->getName(),
                    'email' => $user->getEmail(),
                    'facebook_id' => $user->getId(),
                ]);
                Auth::login($newUser);
            } else {
                Auth::login($findUser);
            }

            return redirect()->route('Acceuil.index'); // Utilise la redirection avec la route nommée
        } catch (Exception $e) {
            dd($e->getMessage());
        }
    }
}
