<?php

namespace App\Http\Controllers\User;

use App\Group;
use App\Http\Controllers\HomeController;
// use Folklore\Image\ImageServiceProvider;

use App\ImageUpload;
use App\Payment;
use App\Subscription;
use App\User;
use Auth;
use Illuminate\Http\Request;
use JD\Cloudder\Facades\Cloudder;

class ProfileController extends HomeController
{
    public function __construct()
    {
        $this->middleware('auth');
        $this->user = new User;
        $this->group = new Group;
        $this->payment = new Payment;
        $this->subscription = new Subscription;
    }

    public function index()
    {
        $user_id = auth()->guard('web')->user()->id;

        $profile = $this->user->findData($user_id);
        $last_paln = $this->subscription->getCurrentSubscription($user_id);
        $current_status = $this->subscription->currentStatus($user_id);
        $trial_details = $this->subscription->trial_end($user_id);
        $next_billing;
        if ($trial_details["ends_at"] !== null) {
            $next_billing = date("d-m-Y", strtotime($trial_details["ends_at"]));
        } else {
            $next_billing = date("d-m-Y", strtotime($trial_details["trail_end"]));
        }

        error_log($next_billing);

        return view('user.profile', ['profile' => $profile, 'last_paln' => $last_paln, "next_billing" => $next_billing, "current_status" => $current_status]);
    }

    public function update_profile_info(Request $request)
    {
        $input = array_except($request->all(), array('_token'));

        if (!empty($request->image)) {
            $upload_image = Cloudder::upload($request->image, null);
            $image = $upload_image->getResult();
            $input['image'] = $image["secure_url"];
        }
        $user_id = auth()->guard('web')->user()->id;

        $this->user->UpdateData($user_id, $input);

        notificationMsg('success', 'Update User Info Successfully!!');

        return redirect()->route('profile');
    }

    public function update_profile_pass(Request $request)
    {
        if ($request->password == $request->password_confirmation) {
            $user_id = auth()->guard('web')->user()->id;

            $input['password'] = bcrypt($request->password);
            $this->user->UpdateData($user_id, $input);
            //     error_log("==========================");
            // error_log(json_encode($input));
            // error_log("==========================");

            notificationMsg('success', 'Change Password Successfully!!');
        } else {
            notificationMsg('error', 'Password Not Metched!!');
        }
        return redirect()->route('profile');
    }

    public function delete_profile_image()
    {
        $user_id = auth()->guard('web')->user()->id;

        if (!empty(auth()->guard('web')->user()->image)) {
            $input['image'] = ImageUpload::removeFile('/upload/users/' . auth()->guard('web')->user()->image);
        }
        $input['image'] = "";
        $this->user->updateData($user_id, $input);

        notificationMsg('success', 'Delete Image Successfully!!');

        return redirect()->route('profile_index');
    }

    public function user_profile_index($id)
    {
        $user_id = auth()->guard('web')->user()->id;
        $profile = $this->user->sub_user_findData($user_id, $id);
        $group = $this->group->getData($profile->id);

        return view('user.profile.sub_user_profile', compact('profile', 'group'));
    }

    public function update_sub_profile_info(Request $request)
    {
        $user_id = auth()->guard('web')->user()->id;
        $input = array_except($request->all(), array('_token', 'sub_user_id'));

        $this->user->UpdateData($request->sub_user_id, $input);

        notificationMsg('success', 'Updtae User Info Successfully!!');
        return redirect()->route('user_profile_index', $request->sub_user_id);
    }

    public function update_sub_profile_pass(Request $request)
    {
        if ($request->password == $request->password_confirmation) {
            $user_id = auth()->guard('web')->user()->id;

            $input['password'] = bcrypt($request->password);
            $this->user->UpdateData($request->sub_user_id, $input);
            notificationMsg('success', 'Change Password Successfully!!');
        } else {
            notificationMsg('error', 'Password Not Metched!!');
        }
        return redirect()->route('user_profile_index', $request->sub_user_id);
    }

}
