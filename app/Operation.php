<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\ProgressLimit;
use App\Progress;

class Operation extends Model
{
    public function limits(){
        return $this->hasOne('\ProgressLimit', 'operation_id', 'id');
    }

    public function progress(){
        return $this->hasOne('\Progress', 'operation_id', 'id');
    }
}
