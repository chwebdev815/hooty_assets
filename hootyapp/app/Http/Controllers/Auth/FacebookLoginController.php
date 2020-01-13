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

class FacebookLoginController extends Controller
{
	public function __construct()
    {
        $this->user = new User;
    }

    public function redirectToFacebook()
    {
        return Socialite::driver('facebook')->redirect();
    }

    public function facebook_success($provider)
    {
        if(\Input::get('error')=='access_denied'){
          return redirect('login');
        }

        $user = Socialite::driver($provider)->user();

        $fb_id=$user->getId();

        $name=explode(' ', $user->getName());

        $input = ([
            'firs_tname' => $name[0],
            'last_name' => $name[1],
            'email' => $user->getEmail(),
            'account_type' => $provider,
            'sns_acc_id' => $fb_id,
        ]);


        $userdata = getUserToEmailId($user->getEmail());
            

        if(!$userdata)
        {

            $user_id = $this->user->AddUserData($input);

        }
        else
        {

            $this->user->updateData($userdata->id,$input);
            $user_id = $userdata->id;
        }

        $user = User::find($user_id);
        Auth::login($user);

        return redirect()->route('home');
        
    }
}