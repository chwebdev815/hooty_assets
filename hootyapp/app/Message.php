<?php

namespace App;

use DB;
use Illuminate\Database\Eloquent\Model;

class Message extends Model
{
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'messages';

    protected $guarded = array();

    public function getData($user_id)
    {
        $data = static::select("messages.*", DB::raw('SUM(chets.status) as chat_status'))
            ->where('user_id', $user_id)
            ->leftJoin('chets', 'chets.message_id', 'messages.id')
            ->orderBy('chets.id', 'desc')
            ->groupBy('messages.id')
            ->get();

        return $data;
    }

    public function getUnreadData($user_id)
    {
        $data = static::select("messages.*", DB::raw('SUM(chets.status) as chat_status'))
            ->leftJoin('chets', 'chets.message_id', 'messages.id')
            ->where('chets.status', 1)
            ->where('user_id', $user_id)
            ->orderBy('chets.id', 'desc')
            ->groupBy('messages.id')
            ->get();

        return $data;
    }

    public function deleteData($id, $user_id)
    {
        return static::where('id', $id)->where('user_id', $user_id)->delete();
    }

    public function addData($input)
    {
        return static::create($input);
    }

    public function findData($id)
    {
        return static::find($id);
    }

    public function findDataWithUser($id)
    {
        $data = static::select("messages.*", "users.first_name", "users.last_name", "users.image")
            ->join('users', 'users.id', 'messages.user_id')
            ->where('messages.id', $id)
            ->first();

        return $data;
    }

    public function updateData($message_id, $input)
    {
        static::where('id', $message_id)->update($input);
        return static::where('id', $message_id)->first();
    }

}
