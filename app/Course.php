<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Course extends Model
{
    /*public function courseType(){
        return $this->hasOne('CourseType');
    }
    public function department(){
        return $this->belongsTo('Department');
    }*/

    public function courseworks(){
        return $this->hasMany('App\Coursework');
    }

    public function type(){
        return $this->hasOne('App\CourseType');
    }

    public function department(){
        return $this->belongsTo('App\Department');
    }
}
