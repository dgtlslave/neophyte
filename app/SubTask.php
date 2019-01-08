<?php

namespace App;

use App\Task;
use App\Progress;
use App\Group;
use Illuminate\Database\Eloquent\Model;

class SubTask extends Model
{
    public function task(){
        return $this->belongsTo('\Task', 'id', 'task_id');
    }

    public function progressSub(){
        return $this->hasOne(Progress::class, 'id', 'sub_task_id');
    }
}
