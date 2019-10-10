<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class DTR extends Model
{
    public $timestamps = false;

    protected $fillable = ['assignmentid', 'projectid',  'summonid', 'time', 'date'];
    protected $table = 'dtr';

    protected $appends = ['employee_name', 'project_name', 'employee_id'];
    public $primaryKey = 'dtr_id';


    public function assignmentz()
    {
        return $this->belongsTo('App\Assignment', 'assignmentid');
    }
    public function summonz()
    {
        return $this->belongsTo('App\Summon', 'summonid');
    }
    public function getEmployeeNameAttribute()
    {
        if ($this->assignmentid !== null) {
            return $this->assignmentz->employee_name;
        } else {
            return $this->summonz->employee_name;
        }
    }
    public function projectz()
    {
        return $this->belongsTo('App\Project', 'projectid');
    }

    public function getProjectNameAttribute()
    {
        return $this->projectz->projectname;
    }
    public function getEmployeeIdAttribute()
    {
        if ($this->assignmentid !== null) {
            return $this->assignmentz->employeeid;
        } else {
            return $this->summonz->assignmentz->employeeid;
        }
    }
}
