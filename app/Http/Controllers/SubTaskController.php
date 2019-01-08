<?php

namespace App\Http\Controllers;

use App\SubTask;
use Illuminate\Http\Request;

class SubTaskController extends Controller
{
    public function getAllSubtask(Request $request){
        $subTask = SubTask::where('task_id', '=', $request->task)->get();
        return $subTask;  
    }
}
