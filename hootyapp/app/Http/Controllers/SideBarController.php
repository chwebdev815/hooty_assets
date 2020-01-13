<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Charts;
use App\User;
use App\Group;
use App\Groups_member;
use App\Journalist;
use App\Chat_log;
use App\Message;
use App\Mail\GroupEmail;
use App\Payment;
use Mail;
use DB;


class SideBarController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');

        $this->user = new User;
        $this->group = new Group;
        $this->journalist = new Journalist;
        $this->groups_member = new Groups_member;
        $this->chat_log = new Chat_log;
        $this->message = new Message;
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */

    public function home(Request $request)
    {
        if(isset($request->monthly))
        {
            $end = cal_days_in_month(CAL_GREGORIAN,$request->monthly,date("Y"));
            $month_no = $request->monthly;
        }   
        else
        {
            $end = $lastDayThisMonth = date("t");
            $month_no = date("n", strtotime("first day of this month"));

        }
        $monthName = date("F", mktime(0, 0, 0, $month_no, 10));

        $user_id = auth()->guard('web')->user()->id;

        $Chat_log = Chat_log::where(DB::raw("(DATE_FORMAT(created_at,'%m'))"),date('m'))->get();


        $send=[];
        $resive=[];
        $fullDay=[];
        $Total=0;
        $Send=0;
        $Delivery=0;
        $Open=0;
        $Click=0;
        for ($i=1; $i <= $end; $i++) 
        { 

            $date = $lastDayThisMonth = date('Y').'-'.$month_no.'-'.$i;

            $fullDay[]=$monthName.' - '.$i;

            $T = DB::table('chat_logs')
                            ->join('messages','messages.id','chat_logs.campaign_id')
                            ->where('messages.user_id',$user_id)
                            ->whereDate('chat_logs.created_at',$date)
                            ->count();
            $Total = $Total + $T;

            $S = DB::table('chat_logs')
                            ->join('messages','messages.id','chat_logs.campaign_id')
                            ->where('messages.user_id',$user_id)
                            ->whereDate('chat_logs.created_at',$date)
                            ->sum('Send');
            $Send = $Send + $S;

            $D = DB::table('chat_logs')
                            ->join('messages','messages.id','chat_logs.campaign_id')
                            ->where('messages.user_id',$user_id)
                            ->whereDate('chat_logs.created_at',$date)
                            ->sum('Delivery');
            $Delivery = $Delivery + $D;

            $O = DB::table('chat_logs')
                            ->join('messages','messages.id','chat_logs.campaign_id')
                            ->where('messages.user_id',$user_id)
                            ->whereDate('chat_logs.created_at',$date)
                            ->sum('Open');

            $Open = $Open + $O;


            $C= DB::table('chat_logs')
                            ->join('messages','messages.id','chat_logs.campaign_id')
                            ->where('messages.user_id',$user_id)
                            ->whereDate('chat_logs.created_at',$date)
                            ->sum('Click');
            $Click = $Click + $C;


            $to_click[] = DB::table('chat_logs')
                            ->join('messages','messages.id','chat_logs.campaign_id')
                            ->where('messages.user_id',$user_id)
                            ->whereDate('chat_logs.created_at',$date)
                            ->sum('Click');

            $to_open[] = DB::table('chat_logs')
                            ->join('messages','messages.id','chat_logs.campaign_id')
                            ->where('messages.user_id',$user_id)
                            ->whereDate('chat_logs.created_at',$date)
                            ->sum('Open');
        }


        $paiChart = Charts::create('pie', 'highcharts')
            ->title('Pie Chart')
            ->colors(['#ff0000','#ff00ff','#00D593','#158CED'])
            ->labels(['Send', 'Delivery', 'Open', 'Click'])
            ->values([$Total,$Delivery,$Open,$Click])
            ->dimensions(1000,500)
            ->responsive(true);

       $Clickchart = Charts::multi('bar', 'highcharts')
            ->title("Click")
            ->dimensions(0, 400)
            ->colors(['#ffd902']) 
            ->template("material")
            ->labels($fullDay)
            ->dataset('Click', $to_click);

        $Openchart = Charts::multi('bar', 'highcharts')
            ->title("Open")
            ->dimensions(0, 400) 
            ->colors(['#b702ff'])
            ->template("material")
            ->labels($fullDay)
            ->dataset('Open', $to_open);




        if(auth()->guard('web')->user()->payment == 1)
        {    
            $chat_log = $this->chat_log->getData($user_id);
            $message = $this->message->getUnreadData($user_id);
                

            return view('user.dashboard',compact('chat_log','message','paiChart','Clickchart','Openchart','Send','Delivery','Open','Click','month_no','side_msg'));
        }
        else
        {
            return view('frunted.plans');
        }
    }

    public function home_month()
    {

        $user_id = auth()->guard('web')->user()->id;

        $end = $lastDayThisMonth = date("t",-1);

        $send=[];
        $resive=[];
        $fullDay=[];
        for ($i=1; $i <= $end; $i++) 
        { 
            $currentMonth = date('F');
            $date = $lastDayThisMonth = date('Y-m-'.$i, strtotime($currentMonth . " last month"));

            $fullDay[]=$i;

            $send[$i] = DB::table('chets')
                ->join('messages','messages.id','=','chets.message_id')
                ->whereDate('chets.created_at',$date)
                ->where('messages.user_id',$user_id)
                ->where('chets.sender_id',$user_id)
                ->count();

            $resive[$i] = DB::table('chets')
                ->join('messages','messages.id','=','chets.message_id')
                ->whereDate('chets.created_at',$date)
                ->where('messages.user_id',$user_id)
                ->where('chets.receiver_id',$user_id)
                ->count();
        }

      $Charts = Charts::multi('areaspline', 'highcharts')
          ->title('Chart Report Data Of Month')
          ->colors(['#0000ff', '#3ECA90'])
          ->labels($fullDay)
          ->dataset('Send messages', $send)
          ->dataset('Resive messages', $resive);



        if(auth()->guard('web')->user()->payment == 1)
        {    
            $chat_log = $this->chat_log->getData($user_id);
            $message = $this->message->getUnreadData($user_id);

                

            return view('user.dashboard',compact('chat_log','message','Charts'));
        }
        else
        {
            return view('frunted.plans');
        }
    }

    public function home_type_date(Request $request)
    {

      $user_id = auth()->guard('web')->user()->id;
      if(auth()->guard('web')->user()->payment == 1)
      {    
        if(!empty($request->date))
        {
            $d = explode(' - ', $request->date);
            $date = date_format(date_create($d[0]),"Y-m-d");;
            $end_date = date_format(date_create($d[1]),"Y-m-d");;
            $start_date = $date;
            $send=[];
            $resive=[];
            $i=0;
            while (strtotime($date) <= strtotime($end_date)) {
                $dd=date_create($date);
                $fullDay[] = date_format($dd,"d");
                $send[$i] = DB::table('chets')
                    ->join('messages','messages.id','=','chets.message_id')
                    ->whereDate('chets.created_at',$date)
                    ->where('messages.user_id',$user_id)
                    ->where('chets.sender_id',$user_id)
                    ->count();

                $resive[$i] = DB::table('chets')
                    ->join('messages','messages.id','=','chets.message_id')
                    ->whereDate('chets.created_at',$date)
                    ->where('messages.user_id',$user_id)
                    ->where('chets.receiver_id',$user_id)
                    ->count();

                        $date = date ("Y-m-d", strtotime("+1 day", strtotime($date)));
                $i++;
            }

              $chat_log = $this->chat_log->getData($user_id);
              $message = $this->message->getUnreadData($user_id);

                  $Charts =Charts::multi('areaspline', 'highcharts')
                        ->title($start_date .' - '.$end_date)
                        ->colors(['#0000ff', '#3ECA90'])
                        ->labels($fullDay)
                        ->dataset('Send messages', $send)
                        ->dataset('Resive messages', $resive);

              return view('user.dashboard',compact('chat_log','message','Charts'));
        }
      }
      else
      {
          return view('frunted.plans');
      }
    }

    public function show_email_click_list($message_id)
    {
        $chat_log = $this->chat_log->findData($message_id);
        return response()->json($chat_log);
    }

    public function search()
    {
        $data = DB::table('groups')->select("*")->get();
        error_log($data);
        return view('user.search', compact('data'));

    }



    public function list()
    {
        $lists = DB::table('groups')
        ->join('groups_members', 'groups.id', '=', 'groups_members.groups_id')
        ->select('name','groups.id', DB::raw("count(groups_members.groups_id) as count"))
        ->groupBy('groups.id')
        ->get();

        return view('user.list',compact('lists'));

    }


    public function individualCampaign()
    {
        
        $id = $_GET['id'];
        if(!empty($_GET['json'])) {
            $json = $_GET['json'];
        }
        $Send = 0;
        $Delivery = 0;
        $Open = 0;
        $Click = 0;

        $user_id = auth()->guard('web')->user()->id;
        
        $campaign = DB::table('messages')
        ->join('chat_logs','messages.id','chat_logs.campaign_id')
        ->select('*')
        ->where('messages.id',$id)
        ->get(); 
        
        
        $S = DB::table('chat_logs')
                            ->join('messages','messages.id','chat_logs.campaign_id')
                            ->where('messages.user_id',$user_id)
                            ->where('messages.id',$id)
                            // ->whereDate('chat_logs.created_at',$date)
                            ->sum('Send');
        $Send = $Send + $S;

        $D = DB::table('chat_logs')
                        ->join('messages','messages.id','chat_logs.campaign_id')
                        ->where('messages.user_id',$user_id)
                        ->where('messages.id',$id)
                        // ->whereDate('chat_logs.created_at',$date)
                        ->sum('Delivery');
        $Delivery = $Delivery + $D;

        $O = DB::table('chat_logs')
                        ->join('messages','messages.id','chat_logs.campaign_id')
                        ->where('messages.user_id',$user_id)
                        ->where('messages.id',$id)
                        // ->whereDate('chat_logs.created_at',$date)
                        ->sum('Open');

        $Open = $Open + $O;


        $C= DB::table('chat_logs')
                        ->join('messages','messages.id','chat_logs.campaign_id')
                        ->where('messages.user_id',$user_id)
                        ->where('messages.id',$id)
                        // ->whereDate('chat_logs.created_at',$date)
                        ->sum('Click');
        $Click = $Click + $C;
        if(isset($json)) {
            $campaign->send = $Send;
            $campaign->delivery = $Delivery;
            $campaign->open = $Open;
            $campaign->click = $Click;
            return json_encode($campaign);
        } else {
            return view('user.individualCampaign',compact('campaign', 'Send', 'Delivery', 'Open', 'Click' ));
        }
        
    }

    public function individualCompose()
    {

        return view('user.individualCompose');

    }
    public function individualList()
    { 
        $id = $_GET['id'];
        $listMembers = DB::table('groups_members')
        ->join('journalists', 'groups_members.member_id', '=', 'journalists.id')
        ->select('journalists.First_name','Domain_name','Outlet_Topic','journalists.id')
        ->where('groups_members.groups_id',$id)
        ->get();
       
        return view('user.individualList',compact('listMembers'));

    }
    public function sideBarMsg(){
     
            $user_id = auth()->guard('web')->user()->id;
            $side_msg = DB::table('chets')
            ->join('journalists', 'chets.sender_id', '=', 'journalists.id')
            ->join('messages','chets.message_id', '=', 'messages.id')
            ->where('chets.receiver_id',$user_id)
            ->where('chets.status',1)
            ->get();
            return json_encode($side_msg);

    }
    
}
