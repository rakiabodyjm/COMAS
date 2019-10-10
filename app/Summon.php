<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Summon extends Model
{
    public $timestamps = false;
    protected $table = 'summon';

    protected $fillable = ['assignmentid', 'projectid', 'date'];

    public $primaryKey = 'summonid';

    protected $appends = ['employee_name', 'project_name'];

    public function assignmentz()
    {
        return $this->belongsTo('App\Assignment', 'assignmentid');
    }
    public function projectz()
    {
        return $this->belongsTo('App\Project', 'projectid');
    }
    public function dtrz()
    {
        return $this->hasOne('App\DTR', 'summonid');
    }
    public function getEmployeeNameAttribute()
    {
        return $this->assignmentz['employee_name'];
    }
    public function getProjectNameAttribute()
    {
        return $this->projectz->projectname;
    }
}
