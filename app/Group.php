<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Aspirant;

class Group extends Model
{

    protected $fillable = ['name'];

    public function aspirant(){
        return $this->hasMany(Aspirant::class, 'group_id', 'id');
    }
}
