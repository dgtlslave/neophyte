<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Group;
use App\Progress;

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

    public function bar(Request $request){
       
        $check = Progress::where([
            ['group_id', '=', $request->groupId],
            ['sub_task_id', '=', $request->subTaskId]
        ])->get(['aspirant_id', 'checked', 'quantity_of_valid'])
          ->groupBy(function($date){
              return $date->aspirant_id;
          }); 
        return $check;  
    }

    public function getAllGroup(){
        $allGroup = Group::with('aspirant', 'progress')->get();
        // $allGroup = Group::with(['aspirant', 'progress'])->get();
        // if($allGroup){
            return $allGroup;
        // }
    }
}
