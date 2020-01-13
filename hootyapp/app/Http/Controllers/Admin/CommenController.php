<?php

namespace App\Http\Controllers\Admin;

use App\Chat_log;
//use Input;
use App\Http\Controllers\Controller;
use App\Journalist;
use Charts;
use DB;
use File;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;

class CommenController extends Controller
{
    /*use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    public function __construct()
    {
    $this->middleware('auth');
    }*/

    public function home(Request $request)
    {
        if (isset($request->monthly)) {
            $end = cal_days_in_month(CAL_GREGORIAN, $request->monthly, date("Y"));
            $month_no = $request->monthly;
        } else {
            $end = $lastDayThisMonth = date("t", -1);
            $month_no = date("n", strtotime("first day of previous month"));

        }
        $monthName = date("F", mktime(0, 0, 0, $month_no, 10));

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
                ->whereDate('chat_logs.created_at', $date)
                ->count();
            $Total = $Total + $T;

            $S = DB::table('chat_logs')
                ->join('messages', 'messages.id', 'chat_logs.campaign_id')
                ->whereDate('chat_logs.created_at', $date)
                ->sum('Send');
            $Send = $Send + $S;

            $D = DB::table('chat_logs')
                ->join('messages', 'messages.id', 'chat_logs.campaign_id')
                ->whereDate('chat_logs.created_at', $date)
                ->sum('Delivery');
            $Delivery = $Delivery + $D;

            $O = DB::table('chat_logs')
                ->join('messages', 'messages.id', 'chat_logs.campaign_id')
                ->whereDate('chat_logs.created_at', $date)
                ->sum('Open');
            $Open = $Open + $O;

            $C = DB::table('chat_logs')
                ->join('messages', 'messages.id', 'chat_logs.campaign_id')
                ->whereDate('chat_logs.created_at', $date)
                ->sum('Click');
            $Click = $Click + $C;

            $to_click[] = DB::table('chat_logs')
                ->join('messages', 'messages.id', 'chat_logs.campaign_id')
                ->whereDate('chat_logs.created_at', $date)
                ->sum('Click');

            $to_open[] = DB::table('chat_logs')
                ->join('messages', 'messages.id', 'chat_logs.campaign_id')
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
            ->template("material")
            ->labels($fullDay)
            ->dataset('Click', $to_click);

        $Openchart = Charts::multi('bar', 'highcharts')
            ->title("Open")
            ->dimensions(0, 400)
            ->colors(['#3ECA90'])
            ->template("material")
            ->labels($fullDay)
            ->dataset('Open', $to_open);
        return view('admin.dashboard', compact('chat_log', 'message', 'paiChart', 'Clickchart', 'Openchart', 'Send', 'Delivery', 'Open', 'Click', 'month_no'));

    }

    public function JournaList()
    {
        $data = DB::table('journalists')->get();
        return view('admin.journalists', ['data' => $data]);
    }

    public function statistics(Request $request)
    {
        return view('admin.statistics');
    }

    public function csv(Request $request)
    {
        //echo "<pre>";
        error_log($request);

        $file = Input::file('frontimage');
        if ($file !== null) {
            //echo $file->getClientOriginalExtension();
            $file_name = str_random(30) . '.' . $file->getClientOriginalExtension();
            $file->move(base_path() . '/public/csv', $file_name);

            $fileD = fopen(base_path() . '/public/csv/' . $file_name, "r");

            $column = fgetcsv($fileD);
            while (!feof($fileD)) {
                $rowData[] = fgetcsv($fileD);
            }
            foreach ($rowData as $key => $value) {
                //print_r($value);die;
                if (!empty($value[0])) {

                    $ins = array('id' => 0, 'email_address' => $value[0], 'Domain_name' => $value[1], 'Organization' => $value[2], 'Confidence_score' => $value[3], 'Type' => $value[4], 'Sources' => $value[5], 'Pattern' => '', 'First_name' => !empty($value[7]) ? $value[7] : '', 'Last_name' => !empty($value[8]) ? $value[8] : '', 'Position' => !empty($value[9]) ? $value[9] : '', 'Twitter_handle' => !empty($value[10]) ? $value[10] : '', 'LinkedIn_URL' => !empty($value[11]) ? $value[11] : '', 'Phone_number' => !empty($value[12]) ? $value[12] : '');

                    $aaa = DB::table('journalists')->where("email_address", $value[0])->count();
                    if (empty($aaa)) {
                        DB::table('journalists')->insert($ins);
                    } else {
                        $ins1 = array('Domain_name' => $value[1], 'Organization' => $value[2], 'Confidence_score' => $value[3], 'Type' => $value[4], 'Sources' => $value[5], 'Pattern' => '', 'First_name' => !empty($value[7]) ? $value[7] : '', 'Last_name' => !empty($value[8]) ? $value[8] : '', 'Position' => !empty($value[9]) ? $value[9] : '', 'Twitter_handle' => !empty($value[10]) ? $value[10] : '', 'LinkedIn_URL' => !empty($value[11]) ? $value[11] : '', 'Phone_number' => !empty($value[12]) ? $value[12] : '');
                        DB::table('journalists')->where("email_address", $value[0])->update($ins1);
                    }

                }
            }
            // print_r($rowData);
        }
        return redirect('/admin/home');

        // die;
    }

    public function JournaList_delete(Request $request)
    {
        if (!empty($request->yourArray)) {
            $data = DB::table('journalists')->whereIn('id', $request->yourArray)->delete();
            return response()->json(true);
        } else {
            return response()->json(false);
        }
    }

}
