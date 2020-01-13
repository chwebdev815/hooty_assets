<?php

namespace App;

use Illuminate\Auth\Authenticatable;
use Illuminate\Database\Eloquent\Model;
use Config;
use DB;

class Chat_log extends Model
{
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'chat_logs';

    protected $guarded = array();

    public function getData($user_id)
    {
        $data = static::select("chat_logs.id","chat_logs.campaign_id",DB::raw('SUM(Send) as Send'),DB::raw('SUM(Reject) as Reject'),DB::raw('SUM(Delivery) as Delivery'),DB::raw('SUM(Open) as Open'),DB::raw('SUM(Click) as Click'),"messages.title")
            ->join('messages','messages.id','chat_logs.campaign_id')
            ->where('messages.user_id',$user_id)
            ->orderBy('chat_logs.id', 'desc')
            ->groupBy('campaign_id')
            ->get();
        return $data;
    }

    public function findData($message_id)
    {
        $data = static::select("chat_logs.id","chat_logs.campaign_id","chat_logs.email_id",DB::raw('SUM(Click) as Click'),"journalists.First_name","journalists.Last_name")
            ->join('journalists','journalists.email_address','chat_logs.email_id')
            ->where('chat_logs.campaign_id',$message_id)
            ->orderBy('chat_logs.id', 'desc')
            ->groupBy('chat_logs.email_id')
            ->get();

        return $data;
    }

    public function addData($input)
    {
        return static::create($input);
    }

}