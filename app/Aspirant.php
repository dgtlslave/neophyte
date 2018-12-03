<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Group;
use App\Progress;

class Aspirant extends Model
{

    protected $fillable = ['group_id', 'first_name', 'last_name', 'avatar'];

    public function group(){
        return $this->belongsTo('\Group', 'id', 'group_id');
    }

    public function progress(){
        return $this->hasOne('\Progress', 'aspirant_id', 'id');
    }

    
}
