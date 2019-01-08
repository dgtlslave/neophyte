<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Aspirant;
use App\Progress;
use App\SubTask;


class Group extends Model
{

    protected $fillable = ['name'];

    public function aspirant(){
        return $this->hasMany(Aspirant::class, 'group_id', 'id');
    }

    public function progress(){
        return $this->hasMany(Progress::class, 'group_id', 'id')->with('sub');
    }
}
