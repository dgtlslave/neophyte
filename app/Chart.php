<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Progress;

class Chart extends Model
{
    public function progress(){
        return $this->hasOne('\Progress', 'id');
    }
}
