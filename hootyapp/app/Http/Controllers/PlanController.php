<?php
namespace App\Http\Controllers;

use App\Payment;
use App\Subscription;
use App\User;
use Auth;
use Illuminate\Http\Request;
use Session;

class PlanController extends Controller
{
    public function __construct()
    {
        $this->user = new User;
        $this->payment = new Payment;
        $this->subscriptions = new Subscription;
    }

    public function hooty_lite_monthly()
    {

        return view('frunted.plans.beta');
    }

    public function view()
    {

        return view('frunted.plans');
    }

    public function hooty_lite_yearly()
    {
        return view('frunted.plans.business');
    }

    public function agency_plan()
    {
        return view('frunted.plans.agency');
    }

    public function payment_success()
    {
        return view('frunted.success');
    }

    public function pay_lite_monthly(Request $request)
    {
        $referral = auth()->guard('web')->user()->referral_id;
        error_log("--------------------------------------------------");
        error_log($referral);
        error_log("--------------------------------------------------");

        $user = auth()->guard('web')->user();
        $stripeToken = $request->stripeToken;
        error_log($stripeToken);

        try {
            $charge = $user->newSubscription('main', '3')
                ->trialDays(30)
                ->create($stripeToken, ['metadata' => array("referral" => $referral)]);
            if ($charge) {
                $user_id = auth()->guard('web')->user()->id;
                $this->subscriptions->setStatus($user_id, 1);
                return redirect('/');
            }

        } catch (Exception $e) {

            \Session::put('error', $e->getMessage());
            return redirect()->route('hooty_lite_monthly');
        }
        // \Session::put('error', 'All fields are required!!');
        return redirect()->route('home');
    }

    public function update_plan(Request $request)
    {
        $user = auth()->guard('web')->user();
        error_log($request->plan);
        $planId = $request->plan;
        $charge = $user->subscription('main')->swap($planId);
        return $charge;

    }

    public function cancel_plan(Request $request)
    {
        $user = auth()->guard('web')->user();
        error_log($user);

        $response = $user->subscription('main')->cancel();
        $user_id = auth()->guard('web')->user()->id;

        $this->subscriptions->setStatus($user_id, -1);
        error_log(json_encode($response));
        return $response;

    }
    public function resume_plan(Request $request)
    {

        $user = auth()->guard('web')->user();

        $charge = $user->subscription('main')->resume();
        error_log($charge);
        $user_id = auth()->guard('web')->user()->id;

        error_log($user_id);

        $this->subscriptions->setStatus($user_id, 1);
        error_log(json_encode($charge));

        return $charge;

    }
    public function pay_lite_yearly(Request $request)
    {
        $referral = auth()->guard('web')->user()->referral_id;
        $user = auth()->guard('web')->user();

        $stripeToken = $request->stripeToken;

        error_log($stripeToken);

        try {
            $charge = $user->newSubscription('main', '4')
                ->trialDays(30)
                ->create($stripeToken, ['metadata' => array("referral" => $referral)]);

            if ($charge) {
                $user_id = auth()->guard('web')->user()->id;

                $this->subscriptions->setStatus($user_id, 1);
                return redirect('/');
            }
        } catch (Exception $e) {

            \Session::put('error', $e->getMessage());
            return redirect()->route('hooty_lite_monthly');
        }
        \Session::put('error', 'All fields are required!!');
        return redirect()->route('hooty_lite_monthly');
    }
    public function walkthrough(Request $request)
    {
        $status = $request->query("status");
        $user_id = auth()->guard('web')->user()->id;
        if ($status === "1") {
            $data = $this->subscriptions->setWalkthroughFalse($user_id, 1);
            return $data;
        } else {
            $data = $this->subscriptions->setWalkthroughFalse($user_id, 0);
            return $data;
        }
    }
    public function renewal_plan()
    {
        $user_id = auth()->guard('web')->user()->id;
        $last_paln = $this->payment->getLastRecord($user_id);
        return view('user.plans', compact('last_paln'));
    }

    public function test()
    {
        $user_id = auth()->guard('web')->user()->id;

        $this->subscriptions->setStatus($user_id, 1);
    }
}
