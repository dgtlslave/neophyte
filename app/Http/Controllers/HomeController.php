<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Group;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('home');
    }

    public function saveGroup(Request $request){
        $request->validate([
            'group'=>'string|required'
        ]);

        $group = Group::firstOrCreate([
            'name'=>$request->group
        ]);

        return 1;
    }



    public function getAllGroup(){
        $allGroup = Group::with('aspirant')->get();
        return $allGroup;
    }
}
