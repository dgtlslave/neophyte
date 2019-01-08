<?php

namespace App;

use App\Task;
use App\Progress;
use Illuminate\Database\Eloquent\Model;

class Task extends Model
{
    public function subTask(){
        return $this->hasMany(SubTask::class, 'task_id', 'id');
    }

    public function progress(){
        return $this->hasOne(Task::class, 'id', 'task_id');
    }
}
