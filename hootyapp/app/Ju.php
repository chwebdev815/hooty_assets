<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Sofa\Eloquence\Eloquence;

class Ju extends Model
{
    /**
     * The database table used by the model.
     *
     * @var string
     */

    use Eloquence;

    protected $searchableColumns = ['First_name', 'Last_name', 'Domain_name', 'Outlet_Topic', "Contact_Topic"];

    protected $table = 'journalists_unique';

    protected $guarded = array();

    public function getData()
    {
        $data = static::select("journalists_unique.*")
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
        return static::where('id', $id)->delete();
    }

    public function findData($id)
    {
        return static::find($id);
    }

    public function upsert($input)
    {
        $journalist = static::where('First_name', $input->First_name)->where('Last_name', $input->Last_name)->where('Domain_name', $input->Domain_name)->first();
        if (empty($journalist)) {
            $jlist['First_name'] = $input->First_name;
            $jlist['Last_name'] = $input->Last_name;
            $jlist['Domain_name'] = $input->Domain_name;
            $jlist['email_address'] = $input->email_address;

            return static::insertGetId($jlist);
        } else {
            return $journalist;
        }
    }

    public function count()
    {
        $data = static::select("journalists_unique.*")
            ->count();

        return $data;
    }

}
