<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Laravel\Cashier\Billable;
class User extends Authenticatable
{
    use Notifiable;
    use Billable;
    protected $table = 'users';
    protected $guarded = array();
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'first_name', 'last_name','user_name', 'company_name', 'type', 'iid', 'email', 'password','account_type','sns_acc_id','image',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    public function getAllData()
    {
        $data = static::select("users.*")
            ->get();

        return $data;
    }

    public function getMainData()
    {
        $data = static::select("users.*")
            ->where('type',1)
            ->get();

        return $data;
    }

    public function getData($user_id)
    {
        $data = static::select("users.*")
            ->where('iid',$user_id)
            ->get();

        return $data;
    }

    public function sub_user_findData($user_id,$sub_user_id)
    {
        $data = static::select("users.*")
            ->where('iid',$user_id)
            ->where('id',$sub_user_id)
            ->first();

        return $data;
    }

    public function AddData($input)
    {
        return static::create($input);
    }

    public function deleteData($id)
    {
        return static::where('id',$id)->delete();
    }

    public function findData($id)
    {
        return static::find($id);
    }

    public function UpdateData($id, $input)
    {
        $user = static::find($id);
       
        if(empty($input["image"])) {
            $input["image"] = $user->image;
        }
 
        return static::where('id', $id)->update($input);
    }

    public function userActive($id)
    {
        $input['user_status'] = 1;
        return static::where('id', $id)->update($input);
    }

    public function userBlock($id)
    {
        $input['user_status'] = 0;
        return static::where('id', $id)->update($input);
    }

    public function AddUserData($input)
    {   
        $data=static::create($input);

        return $data->id;
    }
}
