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
use Illuminate\Http\Request;
use Mail;

class CampaignController extends Controller
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
        $user_id = auth()->guard('web')->user()->id;
        $last_date = $this->payment->checkPlanDate($user_id);
        if (empty($last_date)) {return redirect()->route('renewal_plan');}

        $group = $this->group->getData($user_id);
        $bod = $this->chet_bot->findData($user_id);

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

        return view('user.message.create', compact('group', 'row'));
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

        $this->chet->updtaeStatus($message_id);
        $user_id = auth()->guard('web')->user()->id;

        $message = $this->message->findData($message_id);
        $member = $this->chet->getmemederList($message_id);

        $cfirst = $this->chet->getmemederId($member_id, $message_id);
        if (!empty($cfirst)) {
            $chet = $this->chet->getChetData($cfirst->chet_room_id);
            $journalists_id = $cfirst->journalists_id;

            $chat_log = DB::table('chat_logs')
                ->leftJoin('journalists', 'journalists.email_address', 'chat_logs.email_id')
                ->where('campaign_id', $message_id)
                ->where('journalists.id', $journalists_id)
                ->get();
        } else {
            $chet = '';
            $journalists_id = '';
        }

        $string = 'Delivery-' . $chat_log[0]->Delivery . ' Open-' . $chat_log[0]->Open . ' Click-' . $chat_log[0]->Click;

        return view('user.message.chet_box', compact('member', 'message', 'chet', 'cfirst', 'user_id', 'journalists_id', 'string', 'chat_log'));
    }

    public function sendMail(Request $request)
    {

        $user_id = auth()->guard('web')->user()->id;
        $last_date = $this->payment->checkPlanDate($user_id);
        if (empty($last_date)) {return redirect()->route('renewal_plan');}
        //$em='krupesh8484@gmail.com,krupesh.technocomet@gmail.com';

        define('SENDER', 'andrew.medal@gmail.com');
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
                'key' => 'AKIAJVBMNWVE6YMD7XPA',
                'secret' => '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',
            ],
        ));
        // define('HTMLBODY',$msg);

        //die;
        if (!empty($request->groups)) {
            $sm = str_replace('<p>Hi [First_name],</p>', '', $request->message);

            $ms['user_id'] = $user_id;
            $ms['text'] = $sm;
            $ms['title'] = $request->title;
            $message = $this->message->addData($ms);
            foreach ($request->groups as $key => $value) {
                $groups_member = $this->groups_member->findGroupData($value, $user_id);

                if (!empty($groups_member)) {
                    foreach ($groups_member as $key1 => $value1) {
                        $member = DB::table('journalists')->where('id', $value1->member_id)->first();
                        $path = asset('/mail/replay/') . '/' . $message->id . '231*@m~$!19h~1$S+298' . $value1->member_id;
                        /*$data = [
                        'Message' => $request->message,
                        'link' =>'<a href="'.$path.'" style="background: #7d7d7d;padding: 10px 50px;color: #fff;font-weight: 600;text-decoration: none;">Replay Message</a>'
                        ];*/

                        $receiverEmail = $value1->email_address;
                        //$receiverEmail = 'vikraminphp@gmail.com';
                        //$receiverEmail = 'vikraminphp@gmail.com';
                        $sm = str_replace('[First Name]', $member->First_name, $request->message);

                        $body = '<div style="width:90%;border: 1px solid;padding: 20px;">';
                        $body = $body . $sm;
                        $body = $body . '<br><a href="' . $path . '" style="background: #7d7d7d;padding: 10px 50px;color: #fff;font-weight: 600;text-decoration: none;">Reply Message</a> <br><br>';
                        $body = $body . '</div>';
                        $msg = $body;

                        $tow = explode(',', $receiverEmail);

                        try {
                            $data = ['first_name' => $member->First_name, 'view' => "emails.SendEmail", 'sm' => $sm, 'path' => $path];
                            $result = Mail::to($tow)->send(new TestEmail($data));
                            //  $result = $client->sendEmail([
                            //     'Destination' => [
                            //         'ToAddresses' =>
                            //             $tow,

                            //     ],
                            //     'Message' => [
                            //         'Body' => [
                            //             'Html' => [
                            //                 'Charset' => CHARSET,
                            //                 'Data' => $msg,//HTMLBODY
                            //             ],
                            //       'Text' => [
                            //                 'Charset' => CHARSET,
                            //                 'Data' => TEXTBODY,
                            //             ],
                            //         ],
                            //         'Subject' => [
                            //             'Charset' => CHARSET,
                            //             'Data' => SUBJECT,
                            //         ],
                            //     ],
                            //     'Source' => SENDER,
                            //      'ConfigurationSetName' => CONFIGSET,
                            //      'Tags' => [
                            //         [
                            //             'Name' => 'hooty_a', // REQUIRED
                            //             'Value' => 'hooty_b', // REQUIRED
                            //         ],
                            //         // ...
                            //     ],
                            //             // If you are not using a configuration set, comment or delete the
                            //     // following line
                            //     //'ConfigurationSetName' => CONFIGSET,
                            //     'stats'   => true,
                            // ]);
                            $messageId = uniqid();
                            echo ("Email sent! Message ID: $messageId" . "\n");
                            $rr = array('msg_id' => $messageId, 'email_id' => $receiverEmail, 'campaign_id' => $message->id);
                            DB::table('chat_logs')->insert($rr);
                        } catch (SesException $error) {
                            echo ("The email was not sent. Error message: " . $error->getAwsErrorMessage() . "\n");
                        }

                        //Mail::to($receiverEmail)->send(new GroupEmail($data));
                    }
                }
            }
        }
        //die;
        notificationMsg('success', 'Your Email Submit Successfully!!....');
        return redirect()->route('message');
    }

    public function chetMail(Request $request)
    {
        $user_id = auth()->guard('web')->user()->id;
        $last_date = $this->payment->checkPlanDate($user_id);
        if (empty($last_date)) {return redirect()->route('renewal_plan');}

        $mess = $this->message->findData($request->text);

        define('SENDER', 'andrew.medal@gmail.com');
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
                'key' => 'AKIAJVBMNWVE6YMD7XPA',
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

        $path = asset('/mail/replay/') . '/' . $request->text . '231*@m~$!19h~1$S+298' . $request->last_new_id;

        $member = DB::table('journalists')->where('id', $request->last_new_id)->first();

        $journalist = $this->journalist->findData($request->last_new_id);
        /*$data = [
        'Message' => $request->message,
        'link' =>'<a href="'.$path.'" style="background: #7d7d7d;padding: 10px 50px;color: #fff;font-weight: 600;text-decoration: none;">Replay Message</a>'
        ];*/

        $receiverEmail = $journalist->email_address;

        $body = '<div style="width:90%;border: 1px solid;padding: 20px;">';
        $body = $body . 'Hi ' . $member->First_name;
        $body = $body . $request->message;
        $body = $body . '<br><a href="' . $path . '" style="background: #7d7d7d;padding: 10px 50px;color: #fff;font-weight: 600;text-decoration: none;">Reply Message</a> <br><br>';
        $body = $body . '<p>Thanks,<br>' . auth()->guard('web')->user()->first_name . ' ' . auth()->guard('web')->user()->last_name . '</p>';
        $body = $body . '</div>';
        $msg = $body;

        $tow = explode(',', $receiverEmail);
        // $tow="";
        try {
            $data = ['view' => "emails.ReplyMail", 'message' => $request->message, 'reply_name' => $member->First_name, "path" => $path, "first_name" => auth()->guard('web')->user()->first_name, "last_name" => auth()->guard('web')->user()->last_name];
            Mail::to($tow)->send(new SendEmail($data));
            $messageId = uniqid();
            //     $result = $client->sendEmail([
            //     'Destination' => [
            //         'ToAddresses' =>
            //             $tow,

            //     ],
            //     'Message' => [
            //         'Body' => [
            //             'Html' => [
            //                 'Charset' => CHARSET,
            //                 'Data' => $msg,//HTMLBODY
            //             ],
            //       'Text' => [
            //                 'Charset' => CHARSET,
            //                 'Data' => TEXTBODY,
            //             ],
            //         ],
            //         'Subject' => [
            //             'Charset' => CHARSET,
            //             'Data' => SUBJECT,
            //         ],
            //     ],
            //     'Source' => SENDER,
            //      'ConfigurationSetName' => CONFIGSET,
            //      'Tags' => [
            //         [
            //             'Name' => 'hooty_a', // REQUIRED
            //             'Value' => 'hooty_b', // REQUIRED
            //         ],
            //         // ...
            //     ],
            //             // If you are not using a configuration set, comment or delete the
            //     // following line
            //     //'ConfigurationSetName' => CONFIGSET,
            //     'stats'   => true,
            // ]);
            error_log($tow);
            // $messageId = $result->get('MessageId');

            $rr = array('msg_id' => $messageId, 'chat_id' => $ch->id, 'email_id' => $receiverEmail, 'campaign_id' => $request->text);
            DB::table('chat_logs')->insert($rr);
            //echo("Email sent! Message ID: $messageId"."\n");
        } catch (SesException $error) {
            echo ("The email was not sent. Error message: " . $error->getAwsErrorMessage() . "\n");
        }

        notificationMsg('success', 'Send Email Successfully!!....');
        return redirect()->route('messages_show', $request->text . '231*@m~$!19h~1$S+298' . $request->last_new_id);
    }

    public function replayMail($id)
    {
        if (!empty($id)) {
            $m = explode('231*@m~$!19h~1$S+298', $id);
            $message_id = $m[0];
            $member_id = $m[1];

            $message = $this->message->findDataWithUser($message_id);

            $chet_room = $this->chet_room->findData($message_id, $member_id);

            if (!empty($chet_room)) {
                $chet = $this->chet->getChetData($chet_room->id);
            } else {
                $chet = '';
            }
            return view('frunted.chet', compact('chet', 'message', 'member_id', 'message_id'));
        }
    }

    public function send(Request $request)
    {
        if (!empty($request->message)) {
            $message = $this->message->findData($request->mmiid);

            $chet_room = $this->chet_room->findData($message->id, $request->myiid);
            if (empty($chet_room)) {
                $cr['mes_id'] = $message->id;
                $cr['member_id'] = $request->myiid;
                $chet_room = $this->chet_room->addData($cr);
            }

            $chet['status'] = 1;
            $chet['sender_id'] = $request->myiid;
            $chet['receiver_id'] = $message->user_id;
            $chet['message_id'] = $message->id;
            $chet['chet_room_id'] = $chet_room->id;
            $chet['message'] = $request->message;

            $userInfo = $this->chet_room->getUserData($chet_room->id);
            $path = asset('/mail/replay/') . '/' . $userInfo->mes_id . '231*@m~$!19h~1$S+298' . $userInfo->member_id;

            $this->chet->addData($chet);

            define('SENDER', 'andrew.medal@gmail.com');
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
                    'key' => 'AKIAJVBMNWVE6YMD7XPA',
                    'secret' => '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',
                ],
            ));

            $receiverEmail = $userInfo->user_email;

            $body = '<div style="width:90%;border: 1px solid;padding: 20px;">';
            $body = $body . 'Hi ' . $userInfo->user_fname;
            $body = $body . $request->message;
            $body = $body . '<br><a href="' . $path . '" style="background: #7d7d7d;padding: 10px 50px;color: #fff;font-weight: 600;text-decoration: none;">Show Chat</a> <br><br>';
            $body = $body . '<p>Thanks,<br>' . $userInfo->j_fname . ' ' . $userInfo->j_lname . '</p>';
            $body = $body . '</div>';
            $msg = $body;

            $tow = explode(',', $receiverEmail);

            try {
                $data = ['view' => "emails.ReplyMail", 'message' => $request->message, 'reply_name' => $userInfo->user_fname, "path" => $path, "first_name" => $userInfo->j_fname, "last_name" => $userInfo->j_lname];
                Mail::to($tow)->send(new SendEmail($data));
                //     $result = $client->sendEmail([
                //     'Destination' => [
                //         'ToAddresses' =>
                //             $tow,

                //     ],
                //     'Message' => [
                //         'Body' => [
                //             'Html' => [
                //                 'Charset' => CHARSET,
                //                 'Data' => $msg,//HTMLBODY
                //             ],
                //       'Text' => [
                //                 'Charset' => CHARSET,
                //                 'Data' => TEXTBODY,
                //             ],
                //         ],
                //         'Subject' => [
                //             'Charset' => CHARSET,
                //             'Data' => SUBJECT,
                //         ],
                //     ],
                //     'Source' => SENDER,
                //      'ConfigurationSetName' => CONFIGSET,
                //      'Tags' => [
                //         [
                //             'Name' => 'hooty_a', // REQUIRED
                //             'Value' => 'hooty_b', // REQUIRED
                //         ],
                //         // ...
                //     ],
                //             // If you are not using a configuration set, comment or delete the
                //     // following line
                //     //'ConfigurationSetName' => CONFIGSET,
                //     'stats'   => true,
                // ]);

            } catch (SesException $error) {
                echo ("The email was not sent. Error message: " . $error->getAwsErrorMessage() . "\n");
            }

        }

        notificationMsg('success', 'Send Message Successfully!!....');
        return redirect()->route('index');
    }

    public function search_name(Request $request)
    {
        $member = $this->chet->getmemederListByNmae($request->message_id, $request->name);
        return response()->json($member);
    }

    public function campaigns()
    {
        $user_id = auth()->guard('web')->user()->id;

        $chat_log = DB::table('messages')
            ->leftJoin('chat_logs', 'messages.id', 'chat_logs.campaign_id')
            ->leftJoin('chets', function ($join) {
                $join->on('messages.id', '=', 'chets.message_id')->
                    where('chets.status', 1);
            })
            ->where('user_id', $user_id)
            ->groupBy('messages.id')
            ->select('*', 'messages.id as campaign_id', 'messages.status as msg_status', DB::raw('messages.created_at as Date'), DB::raw('SUM(Send) as Send'), DB::raw('SUM(Delivery) as Delivery'), DB::raw('SUM(Open) as Open'), DB::raw('count(chets.id) as MsgsCount'))
            ->orderBy('messages.updated_at', 'DESC')
            ->get();

        return view('user.campaigns', compact('chat_log'));
    }

}
