<?php

namespace App\Http\Controllers;

use App\Chat_log;
use App\Group;
use App\Groups_member;
use App\Journalist;
use App\Ju;
use App\Message;
use App\Payment;
use App\Subscription;
use App\User;
use Charts;
use DB;
use GuzzleHttp\Client;
use Illuminate\Http\Request;

class HomeController extends Controller
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
        $this->ju = new Ju;
        $this->subscriptions = new Subscription;
    }

    public function latestPitch(Request $request)
    {
        $user_id = auth()->guard('web')->user()->id;
        $last_pitch = DB::table('messages')->where('messages.user_id', $user_id)->orderBy('created_at', 'desc')->first();
        return redirect()->route('campaign_edit', $last_pitch->id);

    }

    public function checkUrlGoodForIframe(Request $request)
    {

        try {
            // error_log($request);
            $client = new Client();
            error_log($request->url);
            $iframeCheckRequest = $client->request('GET', $request->url);
            $iframeCheckRequestHeaders = $iframeCheckRequest->getHeader('x-frame-options');
            $iframeCheckRequestHeaders2 = $iframeCheckRequest->getHeader('Content-Security-Policy');

            error_log(json_encode($iframeCheckRequestHeaders2));
            if ((!empty($iframeCheckRequestHeaders2) && sizeof($iframeCheckRequestHeaders2) > 0 && (strpos($iframeCheckRequestHeaders2[0], "frame-ancestors 'self'") !== false || strpos($iframeCheckRequestHeaders2[0], "disown-opener"))) || in_array("SAMEORIGIN", $iframeCheckRequestHeaders) || in_array("DENY", $iframeCheckRequestHeaders)) {
                $data['success'] = false;
            } else {
                $data['success'] = true;
            }

            return response()->json($data);

            error_log(json_encode($iframeCheckRequestHeaders));
        } catch (\Exception $e) {
            error_log($e);
        }

    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function formatKeywords()
    {

        function normalizeKeyword($keyword)
        {
            if (!empty($keyword)) {
                $keyword = str_replace("'", "", $keyword);
                $keyword = str_replace("; ", ", ", $keyword);
                $keyword_Array = explode(",", $keyword);
                $keyword_Array_Output = array();
                foreach ($keyword_Array as $keyword) {
                    array_push($keyword_Array_Output, ucfirst(trim($keyword)));
                }
                $keyword = implode(", ", $keyword_Array_Output);
                return $keyword;
            } else {
                return "";
            }
        }
        $journalist_count = DB::table('journalists')->select("journalists.*")->where('formatted', 0)->orWhereNull('formatted')->count();
        $journalists = DB::table('journalists')->select("journalists.*")->where('formatted', 0)->orWhereNull('formatted')->limit(10000)->skip(0)->get();

        foreach ($journalists as $journalist) {

            $Contact_Topic = normalizeKeyword($journalist->Contact_Topic);
            $Outlet_Topic = normalizeKeyword($journalist->Outlet_Topic);

            error_log($Contact_Topic);
            error_log($Outlet_Topic);
            error_log($journalist_count);

            $updateData = array('Contact_Topic' => $Contact_Topic, 'Outlet_Topic' => $Outlet_Topic, 'formatted' => 1);
            DB::table('journalists')->where("id", $journalist->id)->update($updateData);

        };

        $data['count'] = $journalist_count;
        $data['success'] = true;

        return response()->json($data);

    }

    public function formatKeywordsView()
    {
        return view('user.formatKeywords');
    }

    public function home(Request $request)
    {
        if (isset($request->monthly)) {
            $end = cal_days_in_month(CAL_GREGORIAN, $request->monthly, date("Y"));
            $month_no = $request->monthly;
        } else {
            $end = $lastDayThisMonth = date("t");
            $month_no = date("n", strtotime("first day of this month"));

        }
        $monthName = date("F", mktime(0, 0, 0, $month_no, 10));

        $user_id = auth()->guard('web')->user()->id;

        $Chat_log = Chat_log::where(DB::raw("(DATE_FORMAT(created_at,'%m'))"), date('m'))->get();

        $send = [];
        $resive = [];
        $fullDay = [];
        $Total = 0;
        $Send = 0;
        $Delivery = 0;
        $Open = 0;
        $Click = 0;

        for ($i = 1; $i <= $end; $i++) {

            $date = $lastDayThisMonth = date('Y') . '-' . $month_no . '-' . $i;

            $fullDay[] = $monthName . ' - ' . $i;

            $T = DB::table('chat_logs')
                ->join('messages', 'messages.id', 'chat_logs.campaign_id')
                ->where('messages.user_id', $user_id)
                ->whereDate('chat_logs.created_at', $date)
                ->count();
            $Total = $Total + $T;

            $S = DB::table('chat_logs')
                ->join('messages', 'messages.id', 'chat_logs.campaign_id')
                ->where('messages.user_id', $user_id)
                ->whereDate('chat_logs.created_at', $date)
                ->sum('Send');
            $Send = $Send + $S;

            $D = DB::table('chat_logs')
                ->join('messages', 'messages.id', 'chat_logs.campaign_id')
                ->where('messages.user_id', $user_id)
                ->whereDate('chat_logs.created_at', $date)
                ->sum('Delivery');
            $Delivery = $Delivery + $D;

            $O = DB::table('chat_logs')
                ->join('messages', 'messages.id', 'chat_logs.campaign_id')
                ->where('messages.user_id', $user_id)
                ->whereDate('chat_logs.created_at', $date)
                ->sum('Open');

            $Open = $Open + $O;

            $C = DB::table('chat_logs')
                ->join('messages', 'messages.id', 'chat_logs.campaign_id')
                ->where('messages.user_id', $user_id)
                ->whereDate('chat_logs.created_at', $date)
                ->sum('Click');
            $Click = $Click + $C;

            $to_click[] = DB::table('chat_logs')
                ->join('messages', 'messages.id', 'chat_logs.campaign_id')
                ->where('messages.user_id', $user_id)
                ->whereDate('chat_logs.created_at', $date)
                ->sum('Click');

            $to_open[] = DB::table('chat_logs')
                ->join('messages', 'messages.id', 'chat_logs.campaign_id')
                ->where('messages.user_id', $user_id)
                ->whereDate('chat_logs.created_at', $date)
                ->sum('Open');
        }

        $paiChart = Charts::create('pie', 'highcharts')
            ->title('Pie Chart')
            ->colors(['#ff0000', '#ff00ff', '#00D593', '#158CED'])
            ->labels(['Send', 'Delivery', 'Open', 'Click'])
            ->values([$Total, $Delivery, $Open, $Click])
            ->dimensions(1000, 500)
            ->responsive(true);

        $Clickchart = Charts::multi('bar', 'highcharts')
            ->title("Click")
            ->dimensions(0, 400)
            ->yAxisTitle("Number of Emails")
            ->colors(['#ffd902'])
            ->template("material")
            ->labels($fullDay)
            ->dataset('Click', $to_click);

        $Openchart = Charts::multi('bar', 'highcharts')
            ->title("Open")
            ->dimensions(0, 400)
            ->yAxisTitle("Number of Emails")
            ->colors(['#b702ff'])
            ->template("material")
            ->labels($fullDay)
            ->dataset('Open', $to_open);

        // $journalists = Journalist::get();

        // foreach ($journalists as $j) {

        //     error_log($j->email_address);

        //     $count = Ju::where('email_address', $j->email_address)->count();

        //     error_log(json_encode("*******"));
        //     error_log($count);
        //     error_log(json_encode("*******"));
        //     if ($count < 1) {
        //         error_log(json_encode("*******"));
        //         error_log(json_encode($j));
        //         Ju::insert($j);
        //     }

        // }
        $walk_through_status = $this->subscriptions->findSetWalkthroughStatus($user_id);
        error_log("+++++++++++++++++++++++++++");
        error_log($walk_through_status);
        error_log("+++++++++++++++++++++++++++");
        return view('user.dashboard', compact('chat_log', 'message', 'paiChart', 'Clickchart', 'Openchart', 'Send', 'Delivery', 'Open', 'Click', 'month_no', 'walk_through_status'));

    }

    public function home_month()
    {

        $user_id = auth()->guard('web')->user()->id;

        $end = $lastDayThisMonth = date("t", -1);

        $send = [];
        $resive = [];
        $fullDay = [];
        for ($i = 1; $i <= $end; $i++) {
            $currentMonth = date('F');
            $date = $lastDayThisMonth = date('Y-m-' . $i, strtotime($currentMonth . " last month"));

            $fullDay[] = $i;

            $send[$i] = DB::table('chets')
                ->join('messages', 'messages.id', '=', 'chets.message_id')
                ->whereDate('chets.created_at', $date)
                ->where('messages.user_id', $user_id)
                ->where('chets.sender_id', $user_id)
                ->count();

            $resive[$i] = DB::table('chets')
                ->join('messages', 'messages.id', '=', 'chets.message_id')
                ->whereDate('chets.created_at', $date)
                ->where('messages.user_id', $user_id)
                ->where('chets.receiver_id', $user_id)
                ->count();
        }

        $Charts = Charts::multi('areaspline', 'highcharts')
            ->title('Chart Report Data Of Month')
            ->colors(['#0000ff', '#3ECA90'])
            ->labels($fullDay)
            ->dataset('Send messages', $send)
            ->dataset('Resive messages', $resive);

        if (auth()->guard('web')->user()->payment == 1) {
            $chat_log = $this->chat_log->getData($user_id);
            $message = $this->message->getUnreadData($user_id);

            return view('user.dashboard', compact('chat_log', 'message', 'Charts'));
        } else {
            return view('frunted.plans');
        }
    }

    public function home_type_date(Request $request)
    {

        $user_id = auth()->guard('web')->user()->id;
        if (auth()->guard('web')->user()->payment == 1) {
            if (!empty($request->date)) {
                $d = explode(' - ', $request->date);
                $date = date_format(date_create($d[0]), "Y-m-d");
                $end_date = date_format(date_create($d[1]), "Y-m-d");
                $start_date = $date;
                $send = [];
                $resive = [];
                $i = 0;
                while (strtotime($date) <= strtotime($end_date)) {
                    $dd = date_create($date);
                    $fullDay[] = date_format($dd, "d");
                    $send[$i] = DB::table('chets')
                        ->join('messages', 'messages.id', '=', 'chets.message_id')
                        ->whereDate('chets.created_at', $date)
                        ->where('messages.user_id', $user_id)
                        ->where('chets.sender_id', $user_id)
                        ->count();

                    $resive[$i] = DB::table('chets')
                        ->join('messages', 'messages.id', '=', 'chets.message_id')
                        ->whereDate('chets.created_at', $date)
                        ->where('messages.user_id', $user_id)
                        ->where('chets.receiver_id', $user_id)
                        ->count();

                    $date = date("Y-m-d", strtotime("+1 day", strtotime($date)));
                    $i++;
                }

                $chat_log = $this->chat_log->getData($user_id);
                $message = $this->message->getUnreadData($user_id);

                $Charts = Charts::multi('areaspline', 'highcharts')
                    ->title($start_date . ' - ' . $end_date)
                    ->colors(['#0000ff', '#3ECA90'])
                    ->labels($fullDay)
                    ->dataset('Send messages', $send)
                    ->dataset('Resive messages', $resive);

                return view('user.dashboard', compact('chat_log', 'message', 'Charts'));
            }
        } else {
            return view('frunted.plans');
        }
    }

    public function show_email_click_list($message_id)
    {
        $chat_log = $this->chat_log->findData($message_id);
        return response()->json($chat_log);
    }

    public function searchJournalists()
    {
        $user_id = auth()->guard('web')->user()->id;
        $data = DB::table('groups')
            ->select('name', 'groups.id')
            ->where('groups.user_id', $user_id)
            ->get();
        return view('user.searchJournalists', compact('data'));
    }

    public function searchArticles()
    {
        $user_id = auth()->guard('web')->user()->id;
        $data = DB::table('groups')
            ->select('name', 'groups.id')
            ->where('groups.user_id', $user_id)
            ->get();

        return view('user.searchArticles', compact('data'));

    }

    public function singleArticle($id)
    {
        error_log($id);
        $articleId = $id;
        return view('user.singleArticle', compact('articleId'));
    }

    function list() {
        $user_id = auth()->guard('web')->user()->id;
        $lists = DB::table('groups')
            ->join('groups_members', 'groups.id', '=', 'groups_members.groups_id')
            ->select('name', 'groups.id', DB::raw("count(groups_members.groups_id) as count"))
            ->where('groups.user_id', $user_id)
            ->groupBy('groups.id')
            ->get();
        return view('user.list', compact('lists'));
    }

    public function individualCampaign()
    {

        $id = $_GET['id'];
        $Send = 0;
        $Delivery = 0;
        $Open = 0;
        $Click = 0;

        $user_id = auth()->guard('web')->user()->id;

        $campaign = DB::table('messages')
            ->leftJoin('chat_logs', 'messages.id', 'chat_logs.campaign_id')
            ->where('messages.id', $id)
            ->where('user_id', $user_id)
            ->groupBy('messages.id')
            ->select('*', 'messages.id as campaign_id', DB::raw('SUM(Send) as Send'), DB::raw('SUM(Delivery) as Delivery'), DB::raw('SUM(Open) as Open'))
            ->first();

        $listwise_reports = '';
        $journalist_wise_reports = '';

        $contact_journalists = DB::table('contact_journalists')->where('campaign_id', $id)->first();

        if (!empty($contact_journalists)) {

            $journalist_wise_reports = DB::table('chat_logs')
                ->select('*', DB::raw('SUM(Send) as Send'), DB::raw('SUM(Reject) as Reject'), DB::raw('SUM(Delivery) as Delivery'), DB::raw('SUM(Open) as Open'), DB::raw('SUM(Click) as Click'))
                ->where('chat_logs.campaign_id', $id)
                ->join('journalists', 'journalists.id', 'chat_logs.journalist_id')
                ->groupBy('journalists.id')
                ->get();

        } else {

            $listwise_reports = DB::table('chat_logs')
                ->select('*', DB::raw('SUM(Send) as Send'), DB::raw('SUM(Reject) as Reject'), DB::raw('SUM(Delivery) as Delivery'), DB::raw('SUM(Open) as Open'), DB::raw('SUM(Click) as Click'))
                ->where('chat_logs.campaign_id', $id)
                ->join('groups', 'groups.id', 'chat_logs.group_id')
                ->join('groups_members', 'groups_members.groups_id', 'chat_logs.group_id')
                ->groupBy('chat_logs.group_id')
                ->select('*', DB::raw('COUNT(groups_members.id) as TotalMembers'))
                ->groupBy('chat_logs.group_id')
                ->get();
        }

        return view('user.individualCampaign', compact('campaign', 'listwise_reports', 'journalist_wise_reports'));

    }

    public function individualCompose($id)
    {
        $individual_compose = DB::table('contact_journalists')
            ->where('id', $id)
            ->first();

        if (!empty($individual_compose->messageId)) {
            $campaign = DB::table('messages')
                ->where('id', $individual_compose->messageId)
                ->first();

            error_log(json_encode($campaign));
        }

        $user_id = auth()->guard('web')->user()->id;

        $news = $individual_compose->news;
        $sendingNews = unserialize($news);

        $contact_journalist_id = $id;

        $masher_url = \Config::get('app.movie_masher_url');
        $app_url = \Config::get('app.url');
        $client = new Client();

        // $uploaded_videos_request = $client->request('GET', $masher_url . '/angular-moviemasher/app/php/media.php?group=video&userId=' . $user_id);
        // $uploaded_videos = $uploaded_videos_request->getBody();

        // $mashed_videos_request = $client->request('GET', $masher_url . '/angular-moviemasher/app/php/media.php?group=mash&userId=' . $user_id);
        // $mashed_videos = $mashed_videos_request->getBody();

        $uploaded_videos_request = json_encode(array());
        $uploaded_videos = json_encode(array());
        $mashed_videos = json_encode(array());

        return view('user.individualCompose', compact('app_url', 'campaign', 'sendingNews', 'contact_journalist_id', 'uploaded_videos', 'mashed_videos', 'masher_url'));
    }

    public function individualList()
    {
        $id = $_GET['id'];
        $group = DB::table('groups')->where('id', $id)->first();
        $listMembers = DB::table('groups_members')
            ->join('journalists', 'groups_members.member_id', '=', 'journalists.id')
            ->select('journalists.First_name', 'Domain_name', 'Outlet_Topic', 'journalists.id')
            ->where('groups_members.groups_id', $id)
            ->get();

        return view('user.individualList', compact('listMembers', 'group'));

    }

    public function sendListPitch(Request $request)
    {

        $listName = $request['lists'];
        $listNameJoined = join(",", $listName);

        return redirect()->route('message_create', $listName);

    }

}
