<?php

namespace App\Http\Controllers\User;
use App\Http\Controllers\HomeController;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use Input;
use DB;
use Session;
use Auth;
use App\User;

class SubUserController extends HomeController
{
    public function __construct()
    {
        $this->middleware('auth');
        $this->user = new User;
        $user_id = auth()->guard('web')->user()->id;
        $last_date =$this->payment->checkPlanDate($user_id);
        if(empty($last_date)){return redirect()->route('renewal_plan');}
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
    	$user_id = auth()->guard('web')->user()->id;
        if(auth()->guard('web')->user()->plan_id == 3)
        {
    	    $data['users']=$this->user->getData($user_id);
            return view('user.sub_user.index',['data'=>$data]);
        }
        else
        {
            return redirect()->route('home');
        }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $user_id = auth()->guard('web')->user()->id;
        $input = array_except($request->all(),array('_token'));	
        $input['type'] = 2;
        $input['iid'] = $user_id;
        $input['password']=bcrypt($request->password);
        $this->user->AddData($input);

        notificationMsg('success','User Added Successfully!!');
        return redirect()->route('sub_user.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $id)
    {
        notificationMsg('success','Group Added Successfully!!');
        $this->user->deleteData($id->id);

        return redirect()->route('sub_user.index');
    }
}
