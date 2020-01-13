<?php

namespace App;

use Illuminate\Auth\Authenticatable;
use Illuminate\Database\Eloquent\Model;
use Config;
use DB;

use Nicolaslopezj\Searchable\SearchableTrait;

class JournalistKeyword extends Model
{
    /**
     * The database table used by the model.
     *
     * @var string
     */

    use SearchableTrait;

    protected $searchable = [
        'columns' => [
            'journalists.Contact_Topic' => 10,
            'journalists.Outlet_Topic' => 5,
        ]
    ];

    protected $table = 'journalists';

    protected $guarded = array();

    public function getData()
    {
        $data = static::select("journalists.*")
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

    public function deleteData($id)
    {
        return static::where('id',$id)->delete();
    }

    public function findData($id)
    {
        return static::find($id);
    }

    public function count()
    {
        $data = static::select("journalists.*")
                ->count();

        return $data;
    }
}