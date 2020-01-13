<?php

namespace App;

use Illuminate\Auth\Authenticatable;
use Illuminate\Database\Eloquent\Model;
use Config;
use DB;

class Chet_bot extends Model
{
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'chet_bots';

    protected $guarded = array();


    public function addData($input)
    {
        return static::create($input);
    }

    public function findData($user_id)
    {
        $data = static::select("chet_bots.*")
            ->where('user_id',$user_id)
            ->orderBy('id', 'desc')
            ->first();

        return $data;
    }
}