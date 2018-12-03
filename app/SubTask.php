<?php

namespace App;

use Task;
use Illuminate\Database\Eloquent\Model;

class SubTask extends Model
{
    public function task(){
        return $this->belongsTo('\Task', 'id', 'task_id');
    }
}
