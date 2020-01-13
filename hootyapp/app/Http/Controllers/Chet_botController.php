<?php
namespace App\Http\Controllers;

use App\Chet_bot;
use App\Http\Controllers\HomeController;
use App\Message;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class Chet_botController extends HomeController
{
    public function __construct()
    {
        //$this->middleware('auth');

        $this->user = new User;
        $this->chet_bot = new Chet_bot;
        $this->message = new Message;
    }

    public function store(Request $request)
    {

        // error_log(json_encode($request));

        // return response()->json();

        // $input = array_except(, array('_token', 'userName', 'campaignName'));
        // $data = $this->chet_bot->addData($input);
        try {
            $body = $request->all();

            $answers_raw = $body["form_response"]["answers"];

            $answers = array();

            foreach ($answers_raw as $answer) {
                switch ($answer['type']) {
                    case 'choice':
                        error_log(json_encode($answer['choice']['label']));
                        array_push($answers, $answer['choice']['label']);
                        break;
                    case 'url':
                        error_log(json_encode($answer['url']));
                        array_push($answers, $answer['url']);
                        break;
                    case 'text':
                        array_push($answers, $answer['text']);
                        break;
                }
            }

            $userId = $body["form_response"]["hidden"]["userid"];

            error_log(json_encode($answers));

            error_log(json_encode($answers));
            error_log(json_encode($userId));

            // return response()->json();

            if (!empty($answers)) {
                $row = '<p>Hi [First_name],</p>';
                // $row = $row .'<p>My name is '.auth()->guard('web')->user()->first_name.' '.auth()->guard('web')->user()->last_name.'. And, my company is '.auth()->guard('web')->user()->company_name.' </p>';
                $row = $row . $answers[0] . '. ';
                $row = $row . $answers[1] . '. ';
                $row = $row . $answers[2] . '. ';
                $row = $row . $answers[3] . '. ';
                $row = $row . $answers[4] . '. ';
                $row = $row . $answers[5] . '. ';
                $row = $row . $answers[6];
                $row = $row . '<p>Thanks!</p>';
            }

            $campaign['text'] = $row;
            $campaign['user_id'] = $userId;
            $campaign['title'] = $answers[7];

            $newCampaign = $this->message->addData($campaign);

            $response['data'] = $newCampaign;
            $response['status'] = true;
            $response['message'] = 'Successfully';
            $response['http_status'] = Response::HTTP_OK;

            return response()->json($response);

        } catch (\Exception $e) {
            error_log($e);
        }
    }
}
