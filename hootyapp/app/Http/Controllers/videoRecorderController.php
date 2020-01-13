<?php
namespace App\Http\Controllers;
use App\User;
use App\Group;
use App\Groups_member;
use App\Journalist;
use App\Message;
use App\Chet;
use App\Chet_room;
use App\Chet_bot;
use App\Chat_log;
use App\Payment;
use Illuminate\Http\Request;
use App\Http\Requests;
use Input;
use DB;
use Session;
use Auth;
use App\Mail\GroupEmail;
use Mail;
use Aws\Ses\Exception\Sms;
use Aws\Ses\SesClient;
use Aws\CloudWatchLogs;
use Aws\Ses\Exception\SesException;
use Aws\CloudWatchLogs\CloudWatchLogsClient;
use Aws\CloudWatch\CloudWatchClient;
use AWS;
use App\AwsPostPolicy;

class videoRecorderController extends Controller
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
        $AWS_REGION =getenv('AWS_REGION');
        $AWS_S3_BUCKET = getenv('AWS_S3_BUCKET') ;
        $videos = DB::table('videos')
        ->where('user_id', $user_id)
        ->get();
        return view('user.video', compact('AWS_REGION', 'AWS_S3_BUCKET','videos'));
    }

    public function dropzone(Request $request)
    {
        // Name of the file uploaded
        // $filename = Request::post('filename', '');
        $filename = $request->filename;
       
     
        // Validate file name
        if ( !preg_match("/^[ a-zA-Z0-9\._-]+$/", $filename) )
            return response()->json([
                'success' => 0,
                'message' => "Filename must contain only letters, numbers, dots, underscores and dashes.",
            ]);
     
        // Path in our S3 bucket to upload to
        $filepath = 'tests/';
     
      


        // Set up our policy generator being careful to add conditions that match
        // what our HTML form will be submitting to S3
        $policy = (new AwsPostPolicy(getenv('AWS_ACCESS'), getenv('AWS_SECRET')))
            ->addCondition('', 'acl', 'public-read')
            ->addCondition('starts-with', '$key', $filepath)
            ->addCondition('', 'bucket', getenv('AWS_S3_BUCKET'))
            ->addCondition('', 'success_action_status', 200)
            ->addCondition('', 'content-type', "application/octet-stream");

            
        return response()->json([
            'success' => 1,
            'AWSAccessKeyId' => getenv('AWS_ACCESS'),
            'key' => $filepath . $filename,
            'policy' => $policy->getPolicy(),
            'signature' => $policy->getSignedPolicy(),
        ]);
    }

    
    public function saveAttributes(Request $request)
    {

        $user_id = auth()->guard('web')->user()->id;
        $name = $request['name'];
       
  

        $sa['name'] =  $name;
        $sa['user_id'] = $user_id;

        DB::table('videos')->insert($sa);

        
        return ;
    }
    public function video_delete($id)
    {
        $data = DB::table("videos")
        ->where('videos.id',$id)
        ->delete();

        
        return ;
    }
}