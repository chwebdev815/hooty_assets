<?php
namespace App\Http\Controllers;

use App\Chat_log;
use App\Chet;
use App\Chet_bot;
use App\Chet_room;
use App\Group;
use App\Groups_member;
use App\Journalist;
use App\Mail\SendEmail;
use App\Message;
use App\Payment;
use App\User;
use Auth;
use Aws\Ses\Exception\SesException;
use Aws\Ses\SesClient;
use DB;
use GuzzleHttp\Client;
use Illuminate\Http\Request;
use Mail;

class MessageController extends Controller
{
    public function __construct()
    {
        $this->user = new User;
        $this->group = new Group;
        $this->journalist = new Journalist;
        $this->groups_member = new Groups_member;
        $this->message = new Message;
        $this->chet = new Chet;
        $this->chet_room = new Chet_room;
        $this->chet_bot = new Chet_bot;
        $this->chat_log = new Chat_log;
        $this->payment = new Payment;
    }

    public function index()
    {
        $user_id = auth()->guard('web')->user()->id;
        /*$last_date =$this->payment->checkPlanDate($user_id);
        if(empty($last_date)){return redirect()->route('renewal_plan');}*/
        $message = $this->message->getData($user_id);
        return view('user.message.index', compact('message'));
    }

    public function create()
    {
        $title = isset($_GET['title']) ? $_GET['title'] : ' ';

        $user_id = auth()->guard('web')->user()->id;
        $last_date = $this->payment->checkPlanDate($user_id);
        // if(empty($last_date)){return redirect()->route('renewal_plan');}

        $group = $this->group->getData($user_id);
        // $bod = $this->chet_bot->findData($user_id);

        //UNCOMMENT
        $masher_url = \Config::get('app.movie_masher_url');
        $app_url = \Config::get('app.url');

        $client = new Client();

        $uploaded_videos_request = $client->request('GET', $masher_url . '/angular-moviemasher/app/php/media.php?group=video&userId=' . $user_id);
        $uploaded_videos = $uploaded_videos_request->getBody();

        $mashed_videos_request = $client->request('GET', $masher_url . '/angular-moviemasher/app/php/media.php?group=mash&userId=' . $user_id);
        $mashed_videos = $mashed_videos_request->getBody();
        // //UNCOMMENT

        // error_log($mashed_videos);

        $row = '';

        if (!empty($bod)) {
            $row = '<p>Hi [First_name],</p>';
            $row = $row . '<p>My name is ' . auth()->guard('web')->user()->first_name . ' ' . auth()->guard('web')->user()->last_name . '. And, my company is ' . auth()->guard('web')->user()->company_name . ' </p>';
            $row = $row . $bod->ans_1 . '. ';
            $row = $row . $bod->ans_2 . '. ';
            $row = $row . $bod->ans_3 . '. ';
            $row = $row . $bod->ans_4 . '. ';
            $row = $row . $bod->ans_5 . '. ';
            $row = $row . $bod->ans_6 . '. ';
            $row = $row . $bod->ans_7;
            $row = $row . '<p>Thanks!</p>';
            $row = $row . '<p>' . auth()->guard('web')->user()->first_name . ' ' . auth()->guard('web')->user()->last_name . '<br>';
            $row = $row . auth()->guard('web')->user()->company_name;
        }

        if (isset($_GET['video'])) {
            $videos = json_decode($mashed_videos);
            $item = null;
            foreach ($videos as $video) {
                if ($video->id == $_GET['video']) {
                    $thisVideo = $video;
                    break;
                }
            }
            error_log($mashed_videos);
            $source = str_replace("user-media", "view-video", $thisVideo->source);
            $source = str_replace(".mp4", "", $source);
            $row = '<div><a href="' . $app_url . $source . '"><img src="' . $thisVideo->icon . '"></a><p class="d-none" style="font-size:12px">Click on the video to view</p></div>';
        }

        return view('user.message.create', compact('group', 'row', 'title', 'uploaded_videos', 'mashed_videos', 'masher_url', 'app_url'));
    }

    public function editCampaign($id)
    {

        $user_id = auth()->guard('web')->user()->id;
        $last_date = $this->payment->checkPlanDate($user_id);
        // if(empty($last_date)){return redirect()->route('renewal_plan');}
        $group = $this->group->getData($user_id);
        $campaign = DB::table('messages')
            ->where('id', $id)
            ->first();

        $client = new Client();

        $masher_url = \Config::get('app.movie_masher_url');
        $app_url = \Config::get('app.url');

        $uploaded_videos_request = $client->request('GET', $masher_url . '/angular-moviemasher/app/php/media.php?group=video&userId=' . $user_id);
        $uploaded_videos = $uploaded_videos_request->getBody();

        $mashed_videos_request = $client->request('GET', $masher_url . '/angular-moviemasher/app/php/media.php?group=mash&userId=' . $user_id);
        $mashed_videos = $mashed_videos_request->getBody();

        // $bod = $this->chet_bot->findData($user_id);
        if (!empty($campaign->groups)) {
            $selectedGroups = json_decode($campaign->groups);
        }
        return view('user.message.create', compact('campaign', 'group', 'selectedGroups', 'uploaded_videos', 'mashed_videos', 'masher_url', 'app_url'));
    }

    public function deleteCampaign($id)
    {

        $user_id = auth()->guard('web')->user()->id;

        error_log('Delete campaign ' . $user_id);

        $delete = $this->message->deleteData($id, $user_id);

        // notificationMsg('success','Group Delete Successfully!!');
        return redirect()->route('list');

    }

    public function show($id)
    {
        $user_id = auth()->guard('web')->user()->id;
        /*$last_date =$this->payment->checkPlanDate($user_id);
        if(empty($last_date)){return redirect()->route('renewal_plan');}*/

        $message = $this->message->findData($id);

        $cfirst = $this->chet->getmemederFrist($id);
        if (!empty($cfirst)) {
            $chet = $this->chet->getChetData($cfirst->chet_room_id);
            $journalists_id = $cfirst->journalists_id;

            $chat_log = DB::table('chat_logs')
                ->leftJoin('journalists', 'journalists.email_address', 'chat_logs.email_id')
                ->where('campaign_id', $id)
                ->where('journalists.id', $journalists_id)
                ->get();

            $member = $this->chet->getmemederList($id);
            $this->chet->updtaeStatus($id);

        } else {
            $chet = '';
            $journalists_id = '';
            $member = [];

            $chat_log = DB::table('chat_logs')
                ->select("chat_logs.id", "chat_logs.campaign_id", DB::raw('SUM(Send) as Send'), DB::raw('SUM(Reject) as Reject'), DB::raw('SUM(Delivery) as Delivery'), DB::raw('SUM(Open) as Open'), DB::raw('SUM(Click) as Click'))
                ->where('chat_logs.campaign_id', $message->id)
                ->groupBy('campaign_id')
                ->where('chat_logs.chat_id', 0)
                ->get();

        }
        if (empty($chat_log)) {
            $string = 'Delivery-0 Open-0 Click-0';
        } else {
            $string = 'Delivery-' . $chat_log[0]->Delivery . ' Open-' . $chat_log[0]->Open . ' Click-' . $chat_log[0]->Click;
        }

        return view('user.message.chet_box', compact('member', 'message', 'chet', 'cfirst', 'user_id', 'journalists_id', 'string'));
    }

    public function messages_show($id)
    {

        $data = explode('231*@m~$!19h~1$S+298', $id);
        $message_id = $data[0];
        $member_id = $data[1];
        $group_id = empty($data[2]) ? $data[2] : '';

        $this->chet->updtaeStatus($message_id);
        $user_id = auth()->guard('web')->user()->id;

        $message = $this->message->findData($message_id);
        $member = $this->chet->getmemederList($message_id);

        $cfirst = $this->chet->getmemederId($member_id, $message_id);

        if (!empty($cfirst)) {
            $chet = $this->chet->getChetData($cfirst->chet_room_id);
            $journalists_id = $cfirst->journalists_id;
            $chat_log = DB::table('chat_logs')->leftJoin('journalists', 'journalists.email_address', 'chat_logs.email_id')->where('campaign_id', $message_id)
                ->where('journalists.id', $journalists_id)
                ->get();
        } else {
            $chet = '';
            $journalists_id = '';
        }

        $string = 'Delivery-' . $chat_log[0]->Delivery . ' Open-' . $chat_log[0]->Open . ' Click-' . $chat_log[0]->Click;

        return view('user.message.chet_box', compact('member', 'message', 'chet', 'cfirst', 'user_id', 'journalists_id', 'string', 'chat_log', 'group_id'));
    }

    public function sendgrid_events(Request $request)
    {
        $event_list = array("processed" => "Send", "dropped" => "Reject", "delivered" => "Delivery", "open" => "Open", "Click" => "click", "Bounce" => "bounce");
        $events = json_decode($request->getContent(), true);

        foreach ($events as $event) {
            error_log(array_key_exists($event["event"], $event_list));
            error_log($event["MessageUID"]);
            if (!empty($event["MessageUID"]) && array_key_exists($event["event"], $event_list)) {
                error_log($event["event"]);
                $event_column = $event_list[$event["event"]];
                $update_query = array();
                $update_query[$event_column] = DB::raw($event_column . '+1');
                error_log(json_encode($update_query));
                DB::table('chat_logs')->where('msg_id', $event["MessageUID"])->update($update_query);
            }
        }

        $res = array("A" => "GG");
        return response()->json($res);
    }

    public function sendMail(Request $request)
    {

        error_log("sendMailsendMailsendMailsendMailsendMailsendMailsendMail");

        $user_id = auth()->guard('web')->user()->id;
        // $last_date = $this->payment->checkPlanDate($user_id);
        // if(empty($last_date)){return redirect()->route('renewal_plan');}
        //$em='krupesh8484@gmail.com,krupesh.technocomet@gmail.com';
        define('SENDER', 'hi@hooty.co');
        define('REGION', 'us-west-2');
        define('SUBJECT', $request->title);
        define('CHARSET', 'UTF-8');
        define('TEXTBODY', '');
        define('CONFIGSET', 'hooty');

        $client = SesClient::factory(array(
            'version' => 'latest',
            'debug' => false,
            'region' => REGION,
            'credentials' => [
                'key' => 'AKIAJKXIOXYWVCQIXBBQ',
                'secret' => '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',
            ],
        ));

        if (!empty($request->draft)) {
            error_log('DRAFT!!!!!');
            if (!empty($request->contact_journalist_id)) {
                error_log('ARTICLE JOURNALIST!!!');
                $ms['contact_journalist_id'] = $request->contact_journalist_id;
            }
            $ms['user_id'] = $user_id;
            $ms['text'] = $request->message;
            $ms['title'] = $request->title;
            $ms['groups'] = json_encode($request->groups);

            if (!empty($request->messageId)) {
                $message = $this->message->updateData($request->messageId, $ms);
            } else {
                $message = $this->message->addData($ms);
            }

            DB::table('contact_journalists')->where('id', $request->contact_journalist_id)->update(['messageId' => $message->id]);

            notificationMsg('success', 'Message saved as draft!');

            if (!empty($request->contact_journalist_id)) {
                return redirect()->route('individualCompose', ["id" => $request->contact_journalist_id]);
            } else {
                return redirect()->route('campaign_edit', ["campaignId" => $message->id]);
            }
        }

        // define('HTMLBODY',$msg);

        //die;
        if (!empty($request->groups)) {

            $sm = str_replace('<p>Hi [First_name],</p>', '', $request->message);

            $ms['user_id'] = $user_id;
            $ms['text'] = $sm;
            $ms['title'] = $request->title;
            $ms['status'] = 0;
            if (!empty($request->messageId)) {
                $message = $this->message->updateData($request->messageId, $ms);
                $messageId = $request->messageId;
            } else {
                $message = $this->message->addData($ms);
                $messageId = $message["id"];
            }

            if (!empty($request->contact_journalist_id)) {

                $contact_journalists = DB::table('contact_journalists')->where('id', $request->contact_journalist_id)->first();

                if (!empty($contact_journalists)) {

                    $news = unserialize($contact_journalists->news);
                    foreach ($request->groups as $authorId) {

                        foreach ($news as $key => $article) {

                            if ($article->author_id === $authorId) {

                                $found = $article;

                                $path = asset('/mail/replay/') . '/' . $message->id . '231*@m~$!19h~1$S+298' . $found->author_hooty_id . '231*@m~$!19h~1$S+298' . $request->contact_journalist_id;

                                $receiverEmail = $found->email;
                                $name = $found->author_name;
                                $split = explode(" ", $name);

                                if (sizeOf($split) > 1) {
                                    $sm = str_replace('[First_name]', array_shift($split), $request->message);
                                    $sm = str_replace('[Last_name]', array_shift($split), $sm);
                                } else {
                                    $sm = str_replace('[First_name]', array_shift($split), $request->message);
                                    $sm = str_replace('[Last_name]', "", $sm);
                                }

                                $ms['text'] = $sm;
                                error_log("XXXXX");
                                error_log($messageId);

                                $this->message->updateData($messageId, $ms);

                                $body = '<div style="width:90%;border: 1px solid;padding: 20px;">';
                                $body = $body . $sm;
                                $body = $body . '<br><br> <div><a href="' . $path . '" style="background: #0294FF;padding: 10px 50px;color: #fff;font-weight: 600;text-decoration: none;">Reply Message</a></div><br><br>';
                                $body = $body . '</div>';
                                $msg = $body;
                                $receiverEmail = rtrim($receiverEmail, ".");
                                $tow = explode(',', $receiverEmail);
                                try {
                                    $messageId = uniqid();
                                    $data = ["messageId" => $messageId, 'subject' => $request->subject, 'view' => "emails.SendEmail", 'sm' => $sm, 'path' => $path, "first_name" => auth()->guard('web')->user()->first_name, "last_name" => auth()->guard('web')->user()->last_name];

                                    Mail::to($tow)->send(new SendEmail($data));

                                    echo ("Email sent! Message ID: $messageId" . "\n");
                                    $rr = array('msg_id' => $messageId, 'email_id' => $receiverEmail, 'campaign_id' => $message->id, 'group_id' => $request->contact_journalist_id, 'journalist_id' => $article->author_hooty_id);
                                    $chat_log_id = DB::table('chat_logs')->insertGetId($rr);
                                    $news[$key]->chat_log_id = $chat_log_id;
                                } catch (SesException $error) {
                                    error_log(json_encode($error));
                                    // echo ("The email was not sent. Error message: " . $error->getAwsErrorMessage() . "\n");
                                }
                            }
                        }
                    }

                    DB::table('contact_journalists')->where('id', $request->contact_journalist_id)->update(array("campaign_id" => $message->id, "news" => serialize($news)));

                }
            } else {
                foreach ($request->groups as $key => $value) {
                    $groups_member = $this->groups_member->findGroupData($value, $user_id);

                    if (!empty($groups_member)) {
                        foreach ($groups_member as $key1 => $value1) {
                            if (!empty($value1->email_address)) {
                                $member = DB::table('journalists')->where('id', $value1->member_id)->first();
                                $path = asset('/mail/replay/') . '/' . $message->id . '231*@m~$!19h~1$S+298' . $value1->member_id . '231*@m~$!19h~1$S+298' . $value;

                                $receiverEmail = rtrim($value1->email_address, ".");

                                $first_name = $member->First_name;
                                $last_name = $member->Last_name;

                                $sm = str_replace('[First_name]', $first_name, $request->message);

                                $sm = str_replace('[Last_name]', $last_name, $sm);

                                $ms['text'] = $sm;
                                error_log("XXXXX");
                                error_log($ms['text']);

                                $this->message->updateData($request->messageId, $ms);

                                $body = '<div style="width:90%;border: 1px solid;padding: 20px;">';
                                $body = $body . $sm;
                                $body = $body . '<br><br><div><a href="' . $path . '" style="background: #0294FF;padding: 10px 50px;color: #fff;font-weight: 600;text-decoration: none;">Reply Message</a></div><br><br>';
                                $body = $body . '</div>';
                                $msg = $body;

                                $tow = explode(',', $receiverEmail);

                                try {
                                    $messageId = uniqid();
                                    $data = ['subject' => $request->subject, 'view' => "emails.SendEmail", 'sm' => $sm, 'path' => $path, "messageId" => $messageId];

                                    $result = Mail::to($tow)->send(new SendEmail($data));

                                    // $messageId = $result->get('MessageId');
                                    echo ("Email sent! Message ID: $messageId" . "\n");
                                    $rr = array('msg_id' => $messageId, 'email_id' => $receiverEmail, 'campaign_id' => $message->id, 'group_id' => $value);
                                    DB::table('chat_logs')->insert($rr);
                                } catch (SesException $error) {
                                    // echo ("The email was not sent. Error message: " . $error->getAwsErrorMessage() . "\n");
                                    error_log($error);
                                }
                            }

                        }
                    }
                }

            }
        }
        //die;
        notificationMsg('success', 'Your message was sent successfully to Journalists!');

        return redirect()->route('message_show_chatrooms', ["campaignId" => $message->id]);
    }

    public function chetMail(Request $request)
    {
        $user_id = auth()->guard('web')->user()->id;
        // $last_date =$this->payment->checkPlanDate($user_id);
        // if(empty($last_date)){return redirect()->route('renewal_plan');}
        error_log('######');
        error_log($request);
        error_log('######');

        $mess = $this->message->findData($request->text);

        define('SENDER', 'hi@hooty.co');
        define('REGION', 'us-west-2');
        define('SUBJECT', $mess->title);
        define('CHARSET', 'UTF-8');
        define('TEXTBODY', '');
        define('CONFIGSET', 'hooty');

        $client = SesClient::factory(array(
            'version' => 'latest',
            'debug' => false,
            'region' => REGION,
            'credentials' => [
                'key' => 'AKIAJKXIOXYWVCQIXBBQ',
                'secret' => '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',
            ],
        ));

        $chet_room = $this->chet_room->findData($request->text, $request->last_new_id);

        $chet['message_id'] = $request->text;
        $chet['chet_room_id'] = $chet_room->id;
        $chet['sender_id'] = $user_id;
        $chet['receiver_id'] = $request->last_new_id;
        $chet['message'] = $request->message;

        $ch = $this->chet->addData($chet);

        $path = asset('/mail/replay/') . '/' . $request->text . '231*@m~$!19h~1$S+298' . $request->last_new_id . '231*@m~$!19h~1$S+298' . $request->group_id;

        $member = DB::table('journalists')->where('id', $request->last_new_id)->first();

        $journalist = $this->journalist->findData($request->last_new_id);
        /*$data = [
        'Message' => $request->message,
        'link' =>'<a href="'.$path.'" style="background: #7d7d7d;padding: 10px 50px;color: #fff;font-weight: 600;text-decoration: none;">Replay Message</a>'
        ];*/

        $receiverEmail = $journalist->email_address;
        //$receiverEmail = 'krupesh8484@gmail.com';
        //$receiverEmail = 'vikraminphp@gmail.com';

        $body = '<div style="width:90%;border: 1px solid;padding: 20px;">';
        $body = $body . 'Hi ' . $member->First_name . '<br>';
        $body = $body . $request->message;
        $body = $body . '<br><br><div><a href="' . $path . '" style="background: #0294FF;padding: 10px 50px;color: #fff;font-weight: 600;text-decoration: none;">Reply Message</a></div> <br><br>';
        $body = $body . '<p>Thanks,<br>' . auth()->guard('web')->user()->first_name . ' ' . auth()->guard('web')->user()->last_name . '</p>';
        $body = $body . '</div>';
        $msg = $body;

        $tow = explode(',', $receiverEmail);
        try {
            $data = ['view' => "emails.ReplyMail", 'message' => $request->message, 'reply_name' => $member->First_name, "path" => $path, "first_name" => auth()->guard('web')->user()->first_name, "last_name" => auth()->guard('web')->user()->last_name];
            Mail::to($tow)->send(new SendEmail($data));
            $messageId = uniqid();
            $rr = array('msg_id' => $messageId, 'chat_id' => $ch->id, 'email_id' => $receiverEmail, 'campaign_id' => $request->text, 'group_id' => $request->group_id);
            DB::table('chat_logs')->insert($rr);
            //echo("Email sent! Message ID: $messageId"."\n");
        } catch (SesException $error) {
            echo ("The email was not sent. Error message: " . $error->getAwsErrorMessage() . "\n");
        }

        notificationMsg('success', 'Send Email Successfully!!....');
        return redirect()->route('message_show', ["campaignId" => $request->text, "groupId" => $chet_room->id]);
    }

    public function replayMail($id)
    {
        if (!empty($id)) {
            $m = explode('231*@m~$!19h~1$S+298', $id);
            $message_id = $m[0];
            $member_id = $m[1];
            $group_id = !empty($m[2]) ? $m[2] : '';

            $message = $this->message->findDataWithUser($message_id);

            $chet_room = $this->chet_room->findData($message_id, $member_id);

            if (!empty($chet_room)) {
                $chet = $this->chet->getChetData($chet_room->id);
            } else {
                $chet = '';
            }
            return view('frunted.chet', compact('chet', 'message', 'member_id', 'message_id', 'group_id'));
        }
    }

    public function send(Request $request)
    {

        if (!empty($request->message)) {
            $message = $this->message->findData($request->mmiid);

            $chet_room = $this->chet_room->findData($message->id, $request->myiid);
            $contact_journalists = DB::table('contact_journalists')->where('campaign_id', $message->id)->first();

            if (empty($chet_room)) {
                $cr['mes_id'] = $message->id;
                $cr['member_id'] = $request->myiid;
                $chet_room = $this->chet_room->addData($cr);
            }

            if (!empty($contact_journalists)) {
                $news = unserialize($contact_journalists->news);
                foreach ($news as $key => $value) {
                    if ($news[$key]->author_hooty_id == $request->myiid) {
                        $news[$key]->chat_room_id = $chet_room->id;
                        $news[$key]->unread = 1;
                    }
                }
                DB::table('contact_journalists')->where('id', $contact_journalists->id)->update(array("news" => serialize($news)));
            }

            $group_id = $request->groupid;

            $chet['status'] = 1;
            $chet['sender_id'] = $request->myiid;
            $chet['receiver_id'] = $message->user_id;
            $chet['message_id'] = $message->id;
            $chet['chet_room_id'] = $chet_room->id;
            $chet['message'] = $request->message;

            $userInfo = $this->chet_room->getUserData($chet_room->id);
            $path = asset('/mail/replay/') . '/' . $userInfo->mes_id . '231*@m~$!19h~1$S+298' . $userInfo->member_id . '231*@m~$!19h~1$S+298' . $request->groupid;

            $this->chet->addData($chet);

            define('SENDER', 'hi@hooty.co');
            define('REGION', 'us-west-2');
            define('SUBJECT', $message->title);
            define('CHARSET', 'UTF-8');
            define('TEXTBODY', '');
            define('CONFIGSET', 'hooty');

            $client = SesClient::factory(array(
                'version' => 'latest',
                'debug' => false,
                'region' => REGION,
                'credentials' => [
                    'key' => 'AKIAJKXIOXYWVCQIXBBQ',
                    'secret' => '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',
                ],
            ));

            $receiverEmail = $userInfo->user_email;

            $body = '<div style="width:90%;border: 1px solid;padding: 20px;">';
            $body = $body . 'Hi ' . $userInfo->user_fname;
            $body = $body . $request->message;
            $body = $body . '<br><br><div><a href="' . $path . '" style="background: #0294FF;padding: 10px 50px;color: #fff;font-weight: 600;text-decoration: none;">Show Chat</a></div> <br><br>';
            $body = $body . '<p>Thanks,<br>' . $userInfo->j_fname . ' ' . $userInfo->j_lname . '</p>';
            $body = $body . '</div>';
            $msg = $body;
            $tow = explode(',', $receiverEmail);

            try {
                $data = ['view' => "emails.ReplyMail", 'message' => $request->message, 'reply_name' => $userInfo->user_fname, "path" => $path, "first_name" => $userInfo->j_fname, "last_name" => $userInfo->j_lname];
                Mail::to($tow)->send(new SendEmail($data));

            } catch (SesException $error) {
                echo ("The email was not sent. Error message: " . $error->getAwsErrorMessage() . "\n");
            }

        }

        notificationMsg('success', 'Send Message Successfully!!....');
        return redirect()->route('replayMail', ['id' => $userInfo->mes_id . '231*@m~$!19h~1$S+298' . $userInfo->member_id . '231*@m~$!19h~1$S+298' . $group_id]);
    }

    public function inbox()
    {
        $user_id = auth()->guard('web')->user()->id;
        $campaign = DB::table('messages')->where('user_id', $user_id)->orderBy('updated_at', 'DESC')->first();
        if (!empty($campaign)) {
            $chat_room = DB::table('chet_rooms')
                ->join('journalists', 'journalists.id', 'chet_rooms.member_id')
                ->select('*', 'chet_rooms.id as roomid')
                ->where('mes_id', $campaign->id)
                ->first();

            if (!empty($chat_room)) {
                return redirect()->route('message_show', ['campaignId' => $campaign->id, 'groupId' => $chat_room->roomid]);
            } else {
                return redirect()->route('message_show', ['campaignId' => $campaign->id, 'groupId' => 0]);
            }

        }
        notificationMsg('success', 'No messages to show');
        return view('error_msgs.inboxerror');
    }

    public function getChatRooms($campaignId)
    {

        $user_id = auth()->guard('web')->user()->id;
        $campaign = DB::table('messages')->where('id', $campaignId)->where('user_id', $user_id)->orderBy('updated_at', 'DESC')->first();

        $chat_room = DB::table('chet_rooms')
            ->join('journalists', 'journalists.id', 'chet_rooms.member_id')
            ->select('*', 'chet_rooms.id as roomid')
            ->where('mes_id', $campaign->id)->first();

        $queries = ['campaignId' => $campaign->id, 'groupId' => (!empty($chat_room) ? $chat_room->roomid : 0)];

        return redirect()->route('message_show', $queries);

    }
    public function getMessages($campaignId, $groupId)
    {
        $this->chet->updtaeStatus($campaignId);
        $contact_journalists = DB::table('contact_journalists')->where('campaign_id', $campaignId)->first();

        if (!empty($contact_journalists)) {
            $news = unserialize($contact_journalists->news);
            foreach ($news as $key => $value) {
                if (!empty($news[$key]->chat_room_id) && $news[$key]->chat_room_id == $groupId) {
                    $news[$key]->unread = 0;
                }
            }
            DB::table('contact_journalists')->where('id', $contact_journalists->id)->update(array("news" => serialize($news)));
        }

        $user_id = auth()->guard('web')->user()->id;
        $chat_messages = array();
        $journalist = (object) [];

        $chat_messages = DB::table('chets')
            ->where('chet_room_id', $groupId)
            ->get();

        $chat_rooms = DB::table('chet_rooms')
            ->join('journalists', 'journalists.id', 'chet_rooms.member_id')
            ->select('*', 'chet_rooms.id as roomid')
            ->where('mes_id', $campaignId)->get();

        $chat_room = DB::table('chet_rooms')
            ->where('id', $groupId)->first();

        if (!empty($chat_messages) && sizeof($chat_messages) > 0) {
            $journalist = DB::table('journalists')->where('id', $chat_room->member_id)->first();
        }

        $messages = DB::table('messages')
            ->where('user_id', $user_id)
            ->orderBy('updated_at', 'DESC')
            ->get();

        $message = DB::table('messages')
            ->where('id', $campaignId)
            ->where('user_id', $user_id)
            ->orderBy('updated_at', 'DESC')
            ->first();

        error_log('######JOURNALIST#########');
        error_log(json_encode($chat_room));
        error_log('###############');

        return view('user.message.index', compact('messages', 'message', 'journalist', 'chat_rooms', 'chat_room', 'chat_messages', 'groupId', 'campaignId'));

    }

    public function search_name(Request $request)
    {
        $member = $this->chet->getmemederListByNmae($request->message_id, $request->name);
        return response()->json($member);
    }
}
