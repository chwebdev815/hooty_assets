<?php

namespace App;

use Illuminate\Auth\Authenticatable;
use Illuminate\Database\Eloquent\Model;
use Config;
use DB;

use Nicolaslopezj\Searchable\SearchableTrait;

class Subscription extends Model
{
    /**
     * The database table used by the model.
     *
     * @var string
     */

    protected $table = 'subscriptions';

    protected $guarded = array();

    public function getCurrentSubscription($user_id)
    {
        error_log($user_id);
        // $data = DB::table('subscriptions')->where('user_id', $user_id)->value('stripe_plan');
        $data = DB::table('subscriptions')->where('user_id', $user_id)->value('stripe_plan');
        return $data;
    }
    public function trial_end($user_id)
    {
        error_log($user_id);
        // $data = DB::table('subscriptions')->where('user_id', $user_id)->value('stripe_plan');
        $data = DB::table('subscriptions')->where('user_id', $user_id);
        $trial_end =  $data->value('trial_ends_at');
        $ends_at = $data->value('ends_at');
        error_log($trial_end);
        return array("trail_end" => $trial_end,"ends_at" => $ends_at );
    }

    public function setStatus($user_id,$status)
    {
        error_log("++++++++++++++STATUS+++++++++++++++++++++");
        error_log($user_id);
        error_log($status);
        error_log("++++++++++++++STATUS+++++++++++++++++++++");

        $data = DB::table('users')->where('id', $user_id)->update(['status'=> $status]);
        return $data;
    }

    public function setWalkthroughFalse($user_id,$status){
        $data = DB::table('users')->where('id', $user_id)->update(['walk_through_status'=> $status]);
        return $data;
    }
    
    public function findSetWalkthroughStatus($user_id){
        $data = DB::table('users')->where('id', $user_id)->value('walk_through_status');
        return $data;
    }
    public function currentStatus($user_id){
        $data = DB::table('users')->where('id', $user_id)->value('status');
        return $data;
    }

}