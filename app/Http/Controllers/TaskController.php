<?php

namespace App\Http\Controllers;

use App\Task;
use Illuminate\Http\Request;

class TaskController extends Controller
{
   public function getAllTask(){
       $task = Task::with('subTask')->get();
       return $task;
   }
}
