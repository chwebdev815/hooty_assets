<?php

namespace App;

use Illuminate\Auth\Authenticatable;
use Illuminate\Database\Eloquent\Model;
use Config;
use DB;

class Chet_room extends Model
{
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'chet_rooms';

    protected $guarded = array();

    public function addData($input)
    {
        return static::create($input);
    }

    public function findData($mes_id,$member_id)
    {
        $data = static::select("chet_rooms.*")
            ->where('mes_id',$mes_id)
            ->where('member_id',$member_id)
            ->first();

        return $data;
    }

       public function getUserData($chet_room_id)
    {
        $data = static::select('chet_rooms.*',
                                'users.id as user_id',
                                'users.first_name as user_fname',
                                'users.last_name as user_lname',
                                'users.email as user_email',
                                'users.image as user_image',
                                'journalists.first_name as j_fname',
                                'journalists.last_name as j_lname')
            ->leftJoin('messages','messages.id','chet_rooms.mes_id')
            ->leftJoin('users','users.id','messages.user_id')
            ->leftJoin('journalists','journalists.id','chet_rooms.member_id')
            ->where('chet_rooms.id',$chet_room_id)
            ->first();

        return $data;
    }

}