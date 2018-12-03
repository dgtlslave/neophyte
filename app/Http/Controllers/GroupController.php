<?php

namespace App\Http\Controllers;

use App\Group;
use App\Aspirant;
use Illuminate\Http\Request;

class GroupController extends Controller
{
    public function viewGroup(Group $group){
        return view('group', compact('group')); 
    } 

    public function createAspirant(Request $request){
        if($request[0]['firstName'] && $request[0]['lastName'] && $request[1]['id']){
            $aspirant = Aspirant::create([
                'group_id' => $request[1]['id'],
                'first_name' => $request[0]['firstName'],
                'last_name' => $request[0]['lastName']        
            ]); 
            return 1;
        }
        return 0;
    } 

    public function getAllAspirant(Request $request){
        $result = Aspirant::where('group_id', '=', $request['id'])->get();
        return $result;
    }
}
