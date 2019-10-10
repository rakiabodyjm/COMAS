<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Employee extends Model
{
    public $timestamps = false;

    protected $fillable = ['lname', 'fname', 'address', 'phoneno', 'skillid', 'locationid'];
    protected $table = 'employees';

    public $primaryKey = 'employeeid';

    protected $appends = ['full_name', 'pay'];
    /*public function getSkillName()
    {
        return Skill::where('skillid', $this->skillid)->first()->description;

        //return $this->belongsTo('App\Skill');
    }*/
    // protected $appends = ['project_name'];
    public function getFullNameAttribute()
    {
        return $this->lname . ', ' . $this->fname;
        // return $name;
    }
    public function locationz()
    {
        return $this->belongsTo('App\Location', 'locationid');
    }
    public function skillz()
    {
        return $this->belongsTo('App\Skill', 'skillid');
    }

    public function getPayAttribute()
    {
        return $this->skillz['salaryrate'];
    }

    public function salarydeductionz()
    {
        return $this->hasMany('App\SalaryDeductions', 'employeeid');
    }

    public function assignmentz()
    {
        //foreign key of employee is used
        //before it was hasMany but AssignmentsController returns an array form of assignmentz which defines that there are 
        //multiple possible entries which is wrong, I think
        return $this->hasOne('App\Assignment', 'employeeid');
    }

    public function inventorytransferz()
    {
        return $this->hasMany('App\InventoryTransfer', 'employeeid');
    }
}
