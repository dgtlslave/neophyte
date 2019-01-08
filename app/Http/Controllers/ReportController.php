<?php

namespace App\Http\Controllers;

use App\Report;
use App\Group;
use App\Aspirant;
use App\Progress;
use App\Task;
use App\SubTask;
use App\Http\Controllers\DB;
use Illuminate\Http\Request;

class ReportController extends Controller
{
    public function viewReport(Group $group){
        return view('report', compact('group'));
    }

    public function getAllAspirantReport(Request $request){
        return Aspirant::where('group_id', '=', $request->id)->get();
    }

    public function reportTaskFun(Request $request){
        return Progress::groupBy('group_id')->having('group_id', '=', $request->group_id)->with('task')->get();
    }

    public function reportSubTaskFun(Request $request){
        return SubTask::where('task_id', '=', $request->task_id)->get();
    }

    public function queryRun(Request $request){
        // dd($request->has($request[0]['task']));

        // $result = Progress::select('*');

        
        //     $args = [];
        //     if($request[0]['task']) $args[] = ['task_id', '=', $request[0]['task']];
        //     // dd($args);
        //     if($request[1]['subTask']) $args[] = ['sub_task_id', '=', $request[1]['subTask']];
        //     // if($request[2]['allTools']) $args[] = [['task_id', '=', '*'], ['sub_task_id', '=', '*']];
        //     if($request[3]['aspirant']) $args[] = ['aspirant_id', '=', $request[3]['aspirant']];
        //     // if($request[4]['allAspirant']) $args[] = ['aspirant_id', '=', '*'];
        //     if($request[5]['dateRange']) $args[] = ['check_date', '>=', strtotime($request[5]['dateRange'][0])];
        //     if($request[5]['dateRange']) $args[] = ['check_date', '<=', strtotime($request[5]['dateRange'][1])];
        //     // dd($args);
        //     return $result->where($args)->orWhere()->get();
            
        return Progress::select('*')
                ->where('task_id', '=', $request->has($request[3]['aspirant']))
                ->get();
    } 
}


// public function index(Request $request)
//     {
//         $users = User::all();
//         $clients = Client::all();

//         $results = Project::select('*');
//         if($request->input()){
//            $args = [];
//            if($request->name) $args[] = ['name','LIKE','%'.$request->name.'%'];
//            if($request->client) $args[] = ['client_id','=',$request->client];
//            if($request->user) $args[] = ['user_id','=',$request->user];
//            if($request->est_from) $args[] = ['estimation','>=',$request->est_from];
//            if($request->est_to) $args[] = ['estimation','<=',$request->est_to];
//            $results->where($args);
//            if($request->has_tasks){
//                 $results->whereHas('tasks',function($query){
//                     return $query;
//                 });
//            }
//         }
//         $projects = $results->paginate(20);

//         return view('admin.projects.index', compact('projects','users','clients'));
//     }


// public function index(Request $request)
//     {
//  // Большего для фильтра не надо
//         $users = User::all()->pluck('id','full_name');
//         $projects = Project::all()->pluck('id','name');
//         $tasks = Task::all()->pluck('id','name');
// // База запроса
//         $base = TimeFrame::select('*');

//         $where = [];
//         if($request->input('user')){
// // Выборка по колонке в этой же таблице
//             $where[] = ['user_id','=',$request->input('user')];
//         }
//         if($request->input('task')){
// // Выборка по колонке в этой же таблице
//             $where[] = ['task_id','=',$request->input('task')];
//         }
//         if($request->input('project')){
// // Выборка по колоне из relation
//             $base->whereHas('task', function($q) use ($request){
//                 $q->where('project_id','=',$request->input('project'));
//             });
//         }
//         if($request->input('duration')){
// // Выборка по рассчетному параметру
//             if($request->input('duration') > 60){
//                 $base->whereRaw('ABS(finished_at-started_at) > '.($request->input('duration') * 60));
//             }else{
//                 $base->whereRaw('ABS(finished_at-started_at) < '.($request->input('duration') * 60));
//             }
//         }
// // Фактическое выполнение запроса
//         $timeframes = $base->where($where)->paginate(20);

//         return view('admin.timeframes.index', compact('timeframes','users','projects','tasks'));
//     }