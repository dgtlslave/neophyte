<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Operation;

class ProgressLimit extends Model
{
    public function operation(){
        return $this->belongsTo('\Operation', 'id', 'operation_id');
    }
}
