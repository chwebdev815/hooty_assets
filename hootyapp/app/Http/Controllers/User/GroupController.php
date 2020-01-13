<?php
namespace App\Http\Controllers\User;

use App\Group;
use App\Groups_member;
use App\Http\Controllers\HomeController;
use App\Journalist;
use App\Payment;
use App\User;
use Auth;
use DB;
use GuzzleHttp\Client;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Http\Request;

class GroupController extends HomeController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;
    public function __construct()
    {
        $this->middleware('auth');

        $this->user = new User;
        $this->group = new Group;
        $this->journalist = new Journalist;
        $this->groups_member = new Groups_member;
        $this->payment = new Payment;
    }

    public function index()
    {
        $user_id = auth()->guard('web')->user()->id;
        $last_date = $this->payment->checkPlanDate($user_id);
        if (empty($last_date)) {return redirect()->route('renewal_plan');}
        $data['group'] = $this->group->getData($user_id);

        return view('user.groups.index', ['data' => $data]);
    }

    public function group_member($id)
    {
        $user_id = auth()->guard('web')->user()->id;
        $last_date = $this->payment->checkPlanDate($user_id);
        if (empty($last_date)) {return redirect()->route('renewal_plan');}
        $data['groups_member'] = $this->groups_member->findGroupData($id, $user_id);

        return view('user.groups.group_member', ['data' => $data]);
    }

    public function store(Request $request)
    {

        // return;
        //$input = array_except($request->all(),array('_token'));
        $user_id = auth()->guard('web')->user()->id;
        $last_date = $this->payment->checkPlanDate($user_id);

        // if(empty($last_date)){return redirect()->route('renewal_plan');}

        $records = DB::table('groups')
            ->where('user_id', $user_id)
            ->where('name', $request->name)
            ->get();

        if (!empty($records) && sizeof($records) > 0) {
            $find = $records[0];
        }

        function addAllArticleSearchResults($data)
        {
            if ($data->has('searchQueryPhrase') || $data->has('searchQueryOutlets')) {
                $client = new Client();
                $response = $client->request('POST', \Config::get('app.api_url') . '/v1/sub-articles-search', [
                    'form_params' => [
                        'selectedAllResults' => true,
                        'searchQueryPhrase' => !empty($data->searchQueryPhrase) ? $data->searchQueryPhrase : "",
                        'searchQueryOutlets' => !empty($data->searchQueryOutlets) ? json_encode($data->searchQueryOutlets) : "",
                    ],
                ]);
               
                $body = json_decode($response->getBody());

                return $body;
            }
        }

        function addAllSearchResults($data)
        {
            if ($data->has('name') || $data->has('outlet') || $data->has('keyword')) {
                $columns = array();
                $searchKeys = array();
                if (!empty($data->journalistName)) {
                 
                    array_push($columns, 'First_name');
                    array_push($searchKeys, "*" . $data->journalistName . "*");
                    array_push($columns, 'Last_name');
                    array_push($searchKeys, "*" . $data->journalistName . "*");
                }
               


                if (!is_null($data->outlet) && !empty($data->outlet)) {
                

                    array_push($columns, 'Domain_name');
                    array_push($searchKeys, $data->outlet);
                }

                if (!is_null($data->keyword) && !empty($data->keyword)) {
                  

                    array_push($columns, 'Outlet_Topic');
                    array_push($searchKeys, "*" . $data->keyword . "*");
                    array_push($columns, 'Contact_Topic');
                    array_push($searchKeys, "*" . $data->keyword . "*");
                }

                $journalists = Journalist::search($searchKeys, $columns)->get();
              
                return $journalists;
            }
        }


        if (empty($find)) {

            $input['name'] = $request->name;
            $input['user_id'] = $user_id;
            $group = $this->group->addData($input);

            if ($request->allSearchResultArticles) {

                $members = addAllArticleSearchResults($request);
              
                if (!empty($members)) {
                    foreach ($members as $member) {
                        $gp['groups_id'] = $group->id;
                        $gp['member_id'] = $member;
                        DB::table('groups_members')
                            ->insertGetId($gp);
                    }
                }
            } else if ($request->allSearchResult) {
             

                $members = addAllSearchResults($request);
               
                if (!empty($members)) {
                    foreach ($members as $member) {
                        $gp['groups_id'] = $group->id;
                        $gp['member_id'] = $member->id;
                        DB::table('groups_members')
                            ->insertGetId($gp);
                    }
                }
            } else if (!empty($request->groups)) {
              
                foreach ($request->groups as $key => $value) {
                    $gp['groups_id'] = $group->id;
                    $gp['member_id'] = $value;
                    DB::table('groups_members')
                        ->insertGetId($gp);
                }
            }
            // notificationMsg('success','Group Added Successfully!!');
        } else {
         
            if ($request->allSearchResult) {
                $members = addAllSearchResults($request);
              
                if (!empty($members)) {
                    foreach ($members as $member) {
                        $find_member = DB::table('groups_members')->where('groups_id', $find->id)->where('member_id', $member->id)->first();
                        if (empty($find_member)) {
                            $gp['groups_id'] = $find->id;
                        }

                        $gp['member_id'] = $member->id;
                        DB::table('groups_members')
                            ->insertGetId($gp);
                    }
                }
            } else if (!empty($request->groups)) {
                foreach ($request->groups as $key => $value) {
                    $find_member = DB::table('groups_members')->where('groups_id', $find->id)->where('member_id', $value)->first();

                    if (empty($find_member)) {
                        $gp['groups_id'] = $find->id;
                        $gp['member_id'] = $value;
                        DB::table('groups_members')->insertGetId($gp);
                    }
                }
            }
            notificationMsg('success', 'Group Updated Successfully!!');
        }

        if (!empty($request->isAjaxCall)) {
            return response()->json(array('groupId' => $group->id));
        } else {
            return redirect()->route('list');
        }

    }

    public function delete($id)
    {
        $user_id = auth()->guard('web')->user()->id;
        $group = $this->group->deleteData($id, $user_id);

        if ($group == true) {
            $this->groups_member->deleteGroupData($id);
        }

        // notificationMsg('success','Group Delete Successfully!!');
        return redirect()->route('list');
    }

    public function member_delete($id)
    {
        $user_id = auth()->guard('web')->user()->id;
        $this->groups_member->deleteData($id, $user_id);

        // notificationMsg('success','Group Member Delete Successfully!!');
        return "success";
    }

}
