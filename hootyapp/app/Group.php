<?php

namespace App;

use Illuminate\Auth\Authenticatable;
use Illuminate\Database\Eloquent\Model;
use Config;
use DB;

class Group extends Model
{
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'groups';

    protected $guarded = array();

    public function getData($user_id)
    {
        $data = static::select("groups.*")
            ->join('groups_members', 'groups.id', '=', 'groups_members.groups_id')
            ->where('user_id',$user_id)
            ->groupBy('groups.id')
            ->get();

        return $data;
    }

    public function addData($input)
    {
        return static::create($input);
    }

    public function deleteData($id,$user_id)
    {
        return static::where('id',$id)->where('user_id',$user_id)->delete();
    }

    public function findData($id)
    {
        return static::find($id);
    }

}