<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Project extends Model
{
    public $timestamps = false;

    protected $table = 'project';

    protected $fillable = ['projectname', 'locationid', 'client', 'status'];

    public $primaryKey = 'projectid';



    public function locationz()
    {
        return $this->belongsTo('App\Location', 'locationid');
    }

    public function assignmentz()
    {
        //the pivot table Assignment 
        return $this->hasMany('App\Assignment', 'projectid');
    }
    public function dtrz()
    {
        return $this->hasMany('App\DTR', 'projectid');
    }
    // public function projectName()
    // {

    //     return $this->projectname;
    // }
}
