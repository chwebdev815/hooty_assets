<?php

namespace App\Http\Controllers\Auth;

use Illuminate\Contracts\Auth\Authenticatable;
use App\Http\Controllers\Controller;

use Illuminate\Http\Request;
use App\Http\Requests;
use Socialite;

use Auth;
use Hash;
use Validator;
use App\User;

class LinkedinLoginController extends Controller
{
	public function __construct()
    {
        $this->user = new User;
    }

    public function redirectTolinkedin()
    {
        return Socialite::driver('linkedin')->redirect();
    }

    public function linkedin_success(Request $request)
    {
        if($request->has('error'))
        {
          return redirect()->route('index');
        } 

        try {
            $linkdinUser = Socialite::driver('linkedin')->user();
            $existUser = User::where('email',$linkdinUser->email)->first();
            if($existUser) {
                $user = User::find($existUser->id);
                Auth::login($user);
            }
            else {
                $name=explode(' ', $linkdinUser->name);

                $user = new User;
                $user->first_name = $name[0];
                $user->last_name = $name[1];
                $user->email = $linkdinUser->email;
                $user->sns_acc_id = $linkdinUser->id;
                $user->account_type = 'linkdin';
                $user->save();
                $user = User::find($user->id);
                Auth::login($user);
            }
                return redirect()->to('/home');
        } 
        catch (Exception $e) {
            return 'error';
        }

        
    }

    public function linkedin_cancel()
    {
        return redirect()->route('index');
    }
}