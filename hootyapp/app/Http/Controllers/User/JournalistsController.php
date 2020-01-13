<?php
namespace App\Http\Controllers\User;

use App\Group;
use App\Groups_member;
use App\Http\Controllers\HomeController;
use App\Journalist;
use App\JournalistKeyword;
use App\JournalistOutlet;
use App\Payment;
use App\User;
use Auth;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Http\Request;

class JournalistsController extends HomeController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;
    public function __construct()
    {
        $this->middleware('auth');

        $this->user = new User;
        $this->group = new Group;
        $this->journalist = new Journalist;
        $this->journalistKeyword = new JournalistKeyword;
        $this->journalistOutlet = new JournalistOutlet;
        $this->groups_member = new Groups_member;
        $this->payment = new Payment;
    }

    public function index(Request $request)
    {
        $user_id = auth()->guard('web')->user()->id;
        $last_date = $this->payment->checkPlanDate($user_id);
        // if(empty($last_date)){return redirect()->route('renewal_plan');}
        $d = $request->get('search');
        try {

            $data['group'] = $this->group->getData($user_id);

            $data['search_data'] = $request->get('search');

            if ($request->has('search') && $request->get('search')) {
                $columns = array();
                $searchKeys = array();
                $where = array();
                if (!empty($d['name'])) {
                    // array_push($columns, 'First_name');
                    // array_push($searchKeys, "*" . $d['name'] . "*");
                    // array_push($columns, 'Last_name');
                    // array_push($searchKeys, "*" . $d['name'] . "*");
                    array_push($where, "CONCAT(First_name, ' ', Last_name)  LIKE '%" . $d['name'] . "%'");
                }

                if (!empty($d['outlet'])) {
                    // array_push($columns, 'Domain_name');
                    // array_push($searchKeys, "*" . $d['outlet'] . "*");

                    array_push($where, "Domain_name  LIKE '%" . $d['outlet'] . "%'");
                }

                if (!empty($d['keyword'])) {

                    array_push($where, "Outlet_Topic  LIKE '%" . $d['keyword'] . "%'");
                    array_push($where, "Contact_Topic  LIKE '%" . $d['keyword'] . "%'");
                }

                $limit = $request->get('page') * 50;
                $temp = $limit - 50;
                $where_query = join(" AND ", $where);
                $data['journalist_count'] = Journalist::select("*")->whereRaw($where_query)->count();
                $data['journalist'] = Journalist::select("*")->whereRaw($where_query)->orderBy('Twitter_handle', 'DESC')->orderBy('Phone_number', 'DESC')->orderBy('Last_name', 'ASC')->offset($temp)->limit(50)->get();
                // error_log(json_encode($columns));
                // $emails = array();

                // foreach ($journalists as $key => $item) {
                //     if (empty($item['email_address'])) {
                //         $data['journalist'][] = $item;
                //     } else if (!in_array($item['email_address'], $emails)) {
                //         $emails[] = $item['email_address'];
                //         $data['journalist'][] = $item;
                //     }
                // }

                // error_log(json_encode($data['journalist']));
                return response()->json($data);

            } else {
                return view('user.search', ['data' => $data]);
            }
        } catch (\Exception $e) {
            error_log($e);
        }
    }

    public function journalistEmail(Request $request)
    {
        // error_log($request);
        // error_log('****************************');
        // error_log('Logic is working');

        if ($request->has('search')) {

            $data = Journalist::distinct('email_address')->search($request->get('search'))->get();
            return response()->json($data);
        }

    }

}
