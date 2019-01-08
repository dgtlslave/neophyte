<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Operation;
use App\Aspirant;
use App\Group;
use App\SubTask;
use App\Task;

class Progress extends Model
{
    protected $fillable = ['aspirant_id',
                           'task_id',
                           'group_id',
                           'sub_task_id',
                           'quantity_of_valid',
                           'checked',
                           'check_date'

];

    public function operation(){
        return $this->belongsTo('\Operation', 'id', 'operation_id');
    }

    public function aspirant(){
        return $this->belongsTo(Aspirant::class, 'id', 'aspirant_id');
    }

    public function sub(){
        return $this->belongsTo(SubTask::class, 'sub_task_id', 'id');
    }

    public function task(){
        return $this->belongsTo(Task::class, 'task_id', 'id');
    }
}
