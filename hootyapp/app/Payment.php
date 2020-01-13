<?php

namespace App;

use Illuminate\Auth\Authenticatable;
use Illuminate\Database\Eloquent\Model;
use Config;
use DB;

use Nicolaslopezj\Searchable\SearchableTrait;

class Payment extends Model
{
    /**
     * The database table used by the model.
     *
     * @var string
     */

    protected $table = 'payments';

    protected $guarded = array();

    public function getData()
    {
        $data = static::select("payments.*")
                ->get();

        return $data;
    }

    public function getLastRecord($user_id)
    {
        $data = static::select("payments.*","plans.plan_name")
                ->join('plans','plans.id','payments.plan')
                ->where('user_id',$user_id)
                ->orderBy('id','DESC')
                ->first();

        return $data;
    }

    public function checkPlanDate($user_id)
    {
        $data = static::select("payments.*")
                ->where('user_id',$user_id)
                ->whereDate('expiry_date','>=',date('Y-m-d'))
                ->orderBy('id','DESC')
                ->first();

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

    public function deleteData($id)
    {
        return static::where('id',$id)->delete();
    }

    public function findData($id)
    {
        return static::find($id);
    }

}