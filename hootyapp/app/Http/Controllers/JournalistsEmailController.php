<?php
namespace App\Http\Controllers;
use App\Http\Controllers\HomeController;


use App\Journalist;

use Illuminate\Http\Request;
use App\Http\Requests;
use Input;
use DB;
use Session;
use Auth;
use Illuminate\Http\Response;




class JournalistsEmailController extends HomeController
{
    public function __construct()
    {
       
;
        $this->journalist = new Journalist;
       
    }

   
    public function saveJournalist(Request $request){
        // error_log($request);      
      
            $journalist = $this->journalist->upsert($request);
            error_log(json_encode($journalist));
            return response()->json($journalist);
        // }
    
    }


    public function findJournalist(Request $request){
        
        error_log($request);
        
        $search = $request['First_name'].' '. $request['Last_name'].' '.$request['Domain_name'];

        try{
            $data = Journalist::search($search)->get();
            return $data;
        }catch(Exception $e) {
            error_log($e);
        }
    
    }

}
