<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Socialite;
use App\User;
use App\SocialProfile;
use App\Http\Requests\CreateSocialProfileRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Contracts\Auth\Authenticatable;
use Illuminate\Support\Facades\Hash;
use Validator;

class SocialAuthController extends Controller
{
    public function facebook(){
        return Socialite::driver('facebook')->redirect();
    }

    public function callback(){
        $user = Socialite::driver('facebook')->user();

        $existing = User::whereHas('socialProfiles', function($query) use ($user){
            $query->where('social_id', $user->id);
        })->first();

        if ($existing !== null) {
            Auth::login($existing);
            return redirect('/');
        }


        session()->flash('facebookUser', $user);

        return view('users.facebook', [
            'user' => $user,
        ]);
    }

    public function register(Request $request){
        $data = session('facebookUser');
        
        $username = $request->input('username');

        $user = User::create([
            'name' => $data->name,
            'email' => $data->email,
            'avatar' => $data->avatar,
            'username' => $username,
            'password' => Hash::make($request->input('password')),
        ]);

        $profile = SocialProfile::create([
            'social_id' => $data->id,
            'user_id' => $user->id,
        ]);

        Auth::login($user);
        
        return redirect('/');

    }

    protected function validator(array $data)
    {
        return Validator::make($data, [
            'name' => 'required|string|max:255',
            'username' => 'required|string|max:255|unique:users',
            'email' => 'required|string|email|max:255|unique:users',
        ]);
    }

}
