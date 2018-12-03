<?php

namespace App;

use App\SubTask;
use Illuminate\Database\Eloquent\Model;

class Task extends Model
{
    public function subTask(){
        return $this->hasMany(SubTask::class, 'task_id', 'id');
    }
}
