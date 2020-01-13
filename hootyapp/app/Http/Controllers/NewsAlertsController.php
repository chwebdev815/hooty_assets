<?php
namespace App\Http\Controllers;

use App\Chat_log;
use App\Chet;
use App\Chet_bot;
use App\Chet_room;
use App\Group;
use App\Groups_member;
use App\Journalist;
use App\Message;
use App\Payment;
use App\User;
use Auth;
use DB;
use GuzzleHttp\Client;
use Illuminate\Http\Request;

class NewsAlertsController extends Controller
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

    public function news_alerts()
    {
        $user_id = auth()->guard('web')->user()->id;
        $news_alerts = DB::table('subscribed_news_alerts')
            ->where('user_id', $user_id)
            ->get();

        $journalists = DB::table('contact_journalists')
            ->leftJoin('chets', function ($join) {
                $join->on('chets.message_id', 'contact_journalists.campaign_id')->
                    where('chets.status', 1);
            })
            ->leftJoin('chet_rooms', function ($join) {
                $join->on('chet_rooms.mes_id', 'contact_journalists.campaign_id');
            })
            ->select('contact_journalists.*')
            ->where('contact_journalists.user_id', $user_id)
            ->get();

        error_log(json_encode($journalists));

        return view('user.news_alerts', ['news_alerts' => $news_alerts, 'journalists' => $journalists]);
    }

    public function last_alert(Request $request)
    {
        error_log($request);
        try {
            DB::table('subscribed_news_alerts')->where('id', $request->id)->update(array('updated_at' => $request->date));
        } catch (Exception $e) {
            error_log($e);
        }
        return;
    }

    public function subscribe_news_alerts(Request $request)
    {

        $search = $request->search;
        $outlets = $request->outlets;

        $user = auth()->guard('web')->user();

        $hootyId = DB::table('subscribed_news_alerts')->insertGetId([
            'user_id' => $user->id,
            'search_phrases' => $search,
            'outlets' => json_encode($outlets),
        ]);

        $client = new Client();
        error_log($hootyId);
        error_log(\Config::get('app.subscription_url'));
        $response = $client->request('POST', \Config::get('app.subscription_url') . '/v1/subscribe', [
            'json' => [
                'user_id' => $user->id,
                'email' => $user->email,
                'name' => $user->first_name,
                'phrases' => $search,
                'hooty_id' => $hootyId,
                'outlets' => $outlets,
            ],
        ]);

        return;
    }

    public function subscribe_news_alert_delete($id)
    {

        $data = DB::table("subscribed_news_alerts")
            ->where('subscribed_news_alerts.id', $id)
            ->delete();

        $client = new Client();

        $response = $client->request('POST', \Config::get('app.subscription_url') . '/v1/unsubscribe', [
            'form_params' => [
                'id' => $id,
            ],
        ]);

        return;
    }

    public function show_subscribed_news($id)
    {

        $data = DB::table("subscribed_news_alerts")
            ->where('subscribed_news_alerts.id', $id)->first();

        return view('user.subscribed_news', compact('data'));

    }

    public function subscribe_news_journalist(Request $request)
    {
        error_log(json_encode($request));

        $user_id = auth()->guard('web')->user()->id;
        // error_log(json_encode($request));
        $articleId = json_encode($request['sub_news']);

        $client = new Client();
        error_log(\Config::get('app.api_url') . '/v1/sub-articles-search');
        $response = $client->request('POST', \Config::get('app.api_url') . '/v1/sub-articles-search', [
            'form_params' => [
                'id' => $articleId,
                'selectedAllResults' => !empty($request->selectedAllResults) ? true : false,
                'searchQueryPhrase' => !empty($request->searchQueryPhrase) ? $request->searchQueryPhrase : "",
                'searchQueryOutlets' => !empty($request->searchQueryOutlets) ? json_encode($request->searchQueryOutlets) : "",
            ],
        ]);

        error_log($response->getBody());

        $body = json_decode($response->getBody());

        $store_in_database = serialize($body);

        $id = DB::table('contact_journalists')->insertGetId([
            'user_id' => $user_id,
            'news' => $store_in_database,
        ]);

        return redirect()->route('individualCompose', ["id" => $id]);

    }

}
