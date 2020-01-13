<?php
namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;

use App\User;
use App\Group;
use App\Groups_member;
use App\Journalist;
use Illuminate\Http\Request;
use App\Http\Requests;
use Input;
use DB;
use Session;
use Auth;

class UserController extends Controller
{
    public function __construct()
    {
        $this->user = new User;
        $this->group = new Group;
        $this->journalist = new Journalist;
        $this->groups_member = new Groups_member;
    }

    public function index()
    {
        $user=$this->user->getMainData();
        return view('admin.users.index',compact('user'));
    }

    public function admin_sub_user($user_id)
    {
        $user=$this->user->getData($user_id);
        $$user_id = $user_id;
        return view('admin.users.sub_user',compact('user','user_id'));
    }

    public function admin_sub_user_profile($id)
    {
    	$iid = explode('@@@@', $id);
    	$sub_user_id = $iid[0];
    	$user_id = $iid[1];
        $profile=$this->user->sub_user_findData($user_id,$sub_user_id);
        $group = $this->group->getData($profile->id);
        
        return view('admin.users.sub_user_profile',compact('profile','group'));
    }

    public function admin_user_member($group_id)
    {
        $data['groups_member'] =$this->groups_member->adminGroupMember($group_id);
        $data['group'] = $this->group->findData($group_id);

        return response()->json($data);
    }

    public function message_user()
    {
        $user=$this->user->getAllData();
        return view('admin.messages.user',compact('user'));
    }

    public function admin_user_block($id)
    {
        $user=$this->user->userBlock($id);
        return response()->json($user);
    }

    public function admin_user_active($id)
    {
        $user=$this->user->userActive($id);
        return response()->json($user);
    }

    public function user_profile($id)
    {
        $profile=$this->user->findData($id);
         $group = $this->group->getData($id);
        return view('admin.users.profile',compact('profile','group'));
    }
}