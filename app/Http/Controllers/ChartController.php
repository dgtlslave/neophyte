<?php

namespace App\Http\Controllers;

use App\Chart;
use App\Aspirant;
use App\Progress;
use Illuminate\Http\Request;

class ChartController extends Controller
{
    public function viewChart(Progress $progress){
        return view('chartline', compact('progress')); 
    } 

    public function update(){
        return [
            'label' => ['march', 'april', 'may', 'june'],
            'datasets' => array([
                'label' => 'Sales',
                'backgroundColor' => '#F26202',
                'pointBorderColor' => '#fde140',
                'data' => [1500, 5000, 100, 30000]
            ])
        ];
    }
}

