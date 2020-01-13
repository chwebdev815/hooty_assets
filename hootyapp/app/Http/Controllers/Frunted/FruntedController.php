<?php

namespace App\Http\Controllers\Frunted;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use Input;
use DB;
use Session;

class FruntedController extends Controller
{
    public function __construct()
    {

    }

    public function index()
    {
        return view('frunted.home');
    }
    
    public function pricing()
    {
        return view('frunted.plans');
    }

    public function Privacy()
    {
        return view('frunted.plans');
    }    
}