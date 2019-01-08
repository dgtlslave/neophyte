<?php

namespace App\Http\Controllers;

use App\ResultTable;
use Illuminate\Http\Request;

class ResultTableController extends Controller
{
    public function viewResultTable(){
        return view('resulttable');
    }
}
