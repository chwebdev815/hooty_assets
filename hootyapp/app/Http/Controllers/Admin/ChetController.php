<?php
namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;

use App\User;
use App\Group;
use App\Groups_member;
use App\Journalist;
use App\JournalistKeyword;
use App\Message;
use App\Chet;
use App\Chet_room;
use Illuminate\Http\Request;
use App\Http\Requests;
use Input;
use DB;
use Session;
use Auth;
use App\Mail\GroupEmail;
use Mail;

class ChetController extends Controller
{
    public function __construct()
    {
        $this->user = new User;
        $this->group = new Group;
        $this->journalist = new Journalist;
        $this->journalistKeyword = new JournalistKeyword;
        $this->groups_member = new Groups_member;
        $this->message = new Message;
        $this->chet = new Chet;
        $this->chet_room = new Chet_room;
    }

    public function index($user_id)
    {
        $message=$this->message->getData($user_id);
        return view('admin.messages.index',compact('message'));
    }

    public function chet($id)
    {
        $data = explode('11@@99', $id);
        $message_id = $data[0];
        $user_id = $data[1];

        $message=$this->message->findData($message_id);

        $cfirst=$this->chet->getmemederFrist($message_id);
        if(!empty($cfirst))
        {
            $chet=$this->chet->getChetData($cfirst->chet_room_id);
            $journalists_id = $cfirst->journalists_id;

             $chat_log = DB::table('chat_logs')
                        ->select('chat_logs.*','users.*')
                        ->leftJoin('journalists','journalists.email_address','chat_logs.email_id')
                        ->leftJoin('messages','messages.id','chat_logs.campaign_id')
                        ->leftJoin('users','users.id','messages.user_id')
                        ->where('campaign_id',$message_id)
                        ->where('journalists.id',$journalists_id)
                        ->get();

            $member=$this->chet->getmemederList($message_id);
        }
        else
        {
            $chet = ''; 
            $journalists_id = '';
            $member=[];

            $chat_log = DB::table('chat_logs')
                            ->select("chat_logs.id","chat_logs.campaign_id",DB::raw('SUM(Send) as Send'),DB::raw('SUM(Reject) as Reject'),DB::raw('SUM(Delivery) as Delivery'),DB::raw('SUM(Open) as Open'),DB::raw('SUM(Click) as Click','users.*'))
                            ->leftJoin('messages','messages.id','chat_logs.campaign_id')
                            ->leftJoin('users','users.id','messages.user_id')
                            ->where('chat_logs.campaign_id',$message_id)
                            ->groupBy('campaign_id')
                            ->where('chat_logs.chat_id',0)
                            ->get();
        }
        $string = 'Delivery-'.$chat_log[0]->Delivery.' Open-'.$chat_log[0]->Open.' Click-'.$chat_log[0]->Click;

        return view('admin.messages.chet',compact('member','message','chet','cfirst','user_id','journalists_id','string','chat_log'));
    }

    public function chets($id)
    {
        $data = explode('11@@99', $id);
        $message_id = $data[0];
        $member_id = $data[1];

        $message=$this->message->findData($message_id);
        $user_id = $message->user_id;
        $member=$this->chet->getmemederList($message_id);

        $cfirst=$this->chet->getmemederId($member_id,$message_id);
        if(!empty($cfirst))
        {
            $chet=$this->chet->getChetData($cfirst->chet_room_id);
            $journalists_id = $member_id;

             $chat_log = DB::table('chat_logs')
                        ->select('chat_logs.*','users.*')
                        ->leftJoin('journalists','journalists.email_address','chat_logs.email_id')
                        ->leftJoin('messages','messages.id','chat_logs.campaign_id')
                        ->leftJoin('users','users.id','messages.user_id')
                        ->where('campaign_id',$message_id)
                        ->where('journalists.id',$journalists_id)
                        ->get();
        }
        else
        {
            $chet = ''; 
            $journalists_id = $member_id;
        }
        $string = 'Delivery-'.$chat_log[0]->Delivery.' Open-'.$chat_log[0]->Open.' Click-'.$chat_log[0]->Click;

        return view('admin.messages.chet',compact('member','message','chet','cfirst','user_id','journalists_id','string','chat_log'));
    }

    public function chat_search_name(Request $request)
    {
        $member=$this->chet->getmemederListByNmae($request->message_id,$request->name);
        return response()->json($member);
    }
}