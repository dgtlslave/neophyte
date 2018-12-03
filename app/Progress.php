<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Operation;
use App\Aspirant;

class Progress extends Model
{
    public function operation(){
        return $this->belongsTo('\Operation', 'id', 'operation_id');
    }

    public function aspirant(){
        return $this->belongsTo('\Aspirant', 'id', 'aspirant_id');
    }
}
