<?php

namespace App;

use Illuminate\Auth\Authenticatable;
use Illuminate\Database\Eloquent\Model;
use Config;
use DB;

class Chet extends Model
{
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'chets';

    protected $guarded = array();

    public function getData($message_id)
    {
        $data = static::select("chets.*")
            ->where('message_id',$message_id)
            ->get();

        return $data;
    }

    public function getmemederList($message_id)
    {
        $data = static::select("chets.*",DB::raw('SUM(chets.status) as chat_status'),
                                'journalists.first_name',
                                'journalists.last_name',
                                'journalists.id as journalists_id')
            ->leftJoin('chet_rooms','chet_rooms.id','chets.chet_room_id')
            ->leftJoin('journalists','journalists.id','chet_rooms.member_id')
            ->where('message_id',$message_id)
            ->orderBy('chets.id', 'desc')
            ->get()
            ->unique('chet_room_id');

        return $data;
    }

    public function getmemederListByNmae($message_id,$name)
    {
        $data = static::select("chets.*",DB::raw('SUM(chets.status) as chat_status'),
                                'journalists.first_name',
                                'journalists.last_name',
                                'journalists.id as journalists_id')
            ->leftJoin('chet_rooms','chet_rooms.id','chets.chet_room_id')
            ->leftJoin('journalists','journalists.id','chet_rooms.member_id')
            ->where('message_id',$message_id)
            ->where('First_name','like','%'.$name.'%')
            ->orderBy('chets.id', 'desc')
            ->get()
            ->unique('chet_room_id');

        if(empty($data[0]->message_id))
        {
            return '';
        }

        return $data;
    }

    public function getmemederFrist($message_id)
    {
        $data = $data = static::select("chets.*",'journalists.id as journalists_id')
            ->leftJoin('chet_rooms','chet_rooms.id','chets.chet_room_id')
            ->leftJoin('journalists','journalists.id','chet_rooms.member_id')
            ->where('message_id',$message_id)
            ->orderBy('id', 'desc')
            ->first();

        return $data;
    }

    public function getmemederId($member_id,$message_id)
    {
        $data = $data = static::select("chets.*",'journalists.id as journalists_id')
            ->leftJoin('chet_rooms','chet_rooms.id','chets.chet_room_id')
            ->leftJoin('journalists','journalists.id','chet_rooms.member_id')
            ->where('chet_rooms.member_id',$member_id)
            ->where('chet_rooms.mes_id',$message_id)
            ->orderBy('id', 'desc')
            ->groupBy('chet_room_id')
            ->first();

        return $data;
    }

    public function getChetData($chet_room_id)
    {
        $data = static::select("chets.*",
                                'users.id as user_id',
                                'users.first_name as user_fname',
                                'users.last_name as user_lname',
                                'users.image as user_image',
                                'journalists.first_name as j_fname',
                                'journalists.last_name as j_lname',
                                'chat_logs.chat_id',
                                'chat_logs.Delivery',
                                'chat_logs.Open',
                                'chat_logs.Bounce',
                                'chat_logs.Click')
            ->leftJoin('chat_logs','chat_logs.chat_id','chets.id')
            ->leftJoin('chet_rooms','chet_rooms.id','chets.chet_room_id')
            ->leftJoin('messages','messages.id','chet_rooms.mes_id')
            ->leftJoin('users','users.id','messages.user_id')
            ->leftJoin('journalists','journalists.id','chet_rooms.member_id')
            ->where('chet_room_id',$chet_room_id)
            ->orderBy('id', 'asc')
            ->get();

        return $data;
    }

    public function addData($input)
    {
        return static::create($input);
    }

    public function updtaeStatus($message_id)
    {
        $input['status'] = 0;
        return static::where('message_id', $message_id)->update($input);
    }
}