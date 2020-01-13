<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\User;
use Auth;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class RegisterController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Register Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users as well as their
    | validation and creation. By default this controller uses a trait to
    | provide this functionality without requiring any additional code.
    |
     */

    use RegistersUsers;

    /**
     * Where to redirect users after registration.
     *
     * @var string
     */
    protected $redirectTo = '/home';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest');
    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
        return Validator::make($data, [
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:6|confirmed',
        ]);
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return \App\User
     */
    protected function create(array $data)
    {
        // $randomId = uniqid();
        return User::create([
            'first_name' => $data['first_name'],
            'last_name' => $data['last_name'],
            // 'user_name' => $data['first_name'].$randomId,
            'email' => $data['email'],
            'password' => Hash::make($data['password']),
        ]);
    }

    public function user_register(Request $request)
    {
        error_log('#####PPPPPPP######');
        error_log($request["referral"]);
        error_log('#####PPPPPPP######');
        $existingUser = User::where('email', $request->email)->first();
        error_log(json_encode($existingUser));
        if (!empty($existingUser)) {
            notificationMsg('error', 'An user already exists with the email address ' . $request->email);
            return redirect()->route('register');
        }

        if ($request->password != $request->password_confirmation) {
            notificationMsg('error', 'Password does not match!!');
            return redirect()->route('register');
        }

        $Name = str_replace(' ', '_', $request->first_name);
        $cstrong = true;
        $bytes = openssl_random_pseudo_bytes(4, $cstrong);
        $hex = bin2hex($bytes);
        $user = new User;
        $user->first_name = $request->first_name;
        $user->last_name = $request->last_name;
        $user->user_name = $Name . "_" . $hex;
        $user->company_name = $request->company_name;
        $user->referral_id = $request["referral"];
        $user->email = $request->email;
        $user->password = bcrypt($request->password);
        $user->save();

        $user = User::find($user->id);
        Auth::login($user);

        if (!empty($request->session()->get('redirect_to'))) {
            return redirect()->to($request->session()->get('redirect_to'));
        } else {
            return redirect()->to('/plan/view');
        }

    }
}
