<?php

namespace App\Http\Controllers;

use App\Aspirant;
use App\Group;
use App\Operation;
use Illuminate\Http\Request;

class AspirantController extends Controller
{
    public function viewAspirant(Aspirant $aspirant){
        return view('aspirant', compact('aspirant')); 
    } 
}