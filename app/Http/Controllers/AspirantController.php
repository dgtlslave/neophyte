<?php

namespace App\Http\Controllers;

use App\Aspirant;
use App\ResultTable;
use App\Chart;
use App\Progress;
use App\Group;
use App\Operation;
use Illuminate\Http\Request;
use Carbon\Carbon;

class AspirantController extends Controller
{
    public function viewAspirant(Aspirant $aspirant){
        return view('aspirant', compact('aspirant')); 
    } 

    public function saveResult(Request $request){
        if(isset($request[2]['aspirant']) &&
           isset($request[0]['valid']) &&
           $request[0]['valid'] != 0 && 
           isset($request[0]['checked']) &&
           $request[0]['checked'] != 0 && 
           isset($request[1]['date']) && 
           isset($request[3]['task']) &&
           isset($request[5]['group']) && 
           isset($request[4]['sub_task']))
        { 
            $timestamp = \Carbon\Carbon::parse($request[1]['date'])->timestamp;
            
            $progress = Progress::create([
                'aspirant_id' => $request[2]['aspirant'],
                'task_id' => $request[3]['task'],
                'group_id' => $request[5]['group'],
                'sub_task_id' => $request[4]['sub_task'],
                'quantity_of_valid' => $request[0]['valid'],
                'checked' => $request[0]['checked'],
                'check_date' => $timestamp
            ]);
            return 1;
        }
    }

    public function getCurrentSubTaskResult(Request $request){
        $progress = Progress::where([
                        ['aspirant_id', '=', $request[1]['aspirant']],
                        ['sub_task_id', '=', $request[0]['sub_task']]
                    ])->orderBy('check_date')->get();
        return $progress;
    }

    public function update(Request $request){
        $checkDate = [];
        $checked = [];
        $quantity_of_valid = [];
        for ($x = 0; $x < count($request->progress); $x++) {
            array_push($checkDate, $request->progress[$x]['check_date']);
            array_push($quantity_of_valid, $request->progress[$x]['quantity_of_valid']);
            array_push($checked, $request->progress[$x]['checked']);
        }


        // dd($checked);
        return [
            'labels' => $checkDate,
            'datasets' => array([
                'label' => 'Valid',
                'backgroundColor' => 'rgba(60, 255, 254, 0.6)',
                'pointBorderColor' => '#fde140',
                'data' => $quantity_of_valid
            ],
            [
                'label' => 'Checked',
                'backgroundColor' => 'rgba(112, 114, 129, 0.6)',
                'pointBorderColor' => '#fde140',
                'data' => $checked
            ])
        ];

        // return [
        //     'label' => ['march', 'april', 'may', 'june'],
        //     'datasets' => array([
        //         'label' => 'Sales',
        //         'backgroundColor' => '#F26202',
        //         'pointBorderColor' => '#fde140',
        //         'data' => [15000, 5000, 10000, 30000]
        //     ])
        // ];
    }
}
