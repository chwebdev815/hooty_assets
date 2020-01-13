<?php

namespace App;

use Illuminate\Auth\Authenticatable;
use Illuminate\Database\Eloquent\Model;
use Config;
use DB;

class Groups_member extends Model
{
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'groups_members';

    protected $guarded = array();

    public function getData()
    {
        $data = static::select("groups_members.*")
                ->get();

        return $data;
    }

    public function AddData($input)
    {
        return static::create($input);
    }

    public function UpdateData($id, $input)
    {
        return static::where('id', $id)->update($input);
    }

    public function deleteData($id,$user_id)
    {
         $data = DB::table("groups_members")
                ->join('groups','groups.id','groups_members.groups_id')
                ->where('groups_members.member_id',$id)
                // ->where('groups.user_id',$user_id)
                ->delete();
                error_log('++++++++++++++++++++++++++++++');
                error_log($data);
         error_log($id);
        return $data;
    }

    public function deleteGroupData($id)
    {
        return static::where('groups_id',$id)->delete();
    }

    public function findData($id)
    {
        return static::find($id);
    }

    public function findGroupData($id,$user_id)
    {
         $data = DB::table("groups_members")
                ->select("groups_members.*","journalists.Last_name","journalists.First_name","journalists.email_address")
                ->join('journalists','journalists.id','groups_members.member_id')
                ->join('groups','groups.id','groups_members.groups_id')
                ->where('groups_members.groups_id',$id)
                ->where('groups.user_id',$user_id)
                ->get();

        return $data;
    }

    public function adminGroupMember($id)
    {
         $data = DB::table("groups_members")
                ->select("groups_members.*","journalists.Last_name","journalists.First_name","journalists.email_address")
                ->join('journalists','journalists.id','groups_members.member_id')
                ->join('groups','groups.id','groups_members.groups_id')
                ->where('groups_members.groups_id',$id)
                ->get();

        return $data;
    }

}