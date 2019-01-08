<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Group;
use App\Progress;

class Aspirant extends Model
{

    protected $fillable = ['group_id', 'first_name', 'last_name', 'avatar'];

    public function group(){
        return $this->belongsTo(Group::class, 'id', 'group_id');
    }

    public function progress(){
        return $this->hasOne(Progress::class, 'aspirant_id', 'id');
    }

    
}
