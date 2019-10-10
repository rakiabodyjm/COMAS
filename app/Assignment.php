<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Assignment extends Model
{
    public $timestamps = false;
    protected $table = 'assignment';

    protected $fillable = ['projectid', 'employeeid', 'date', 'active'];

    public $primaryKey = 'assignmentid';

    protected $appends = ['project_name', 'employee_name'];

    public function employeez()
    {
        return $this->belongsTo('App\Employee', 'employeeid', 'employeeid');
    }
    public function projectz()
    {
        // return $this->belongsTo('App\Project', 'projectid');
        return $this->belongsTo('App\Project', 'projectid');
    }


    public function getProjectNameAttribute()
    {
        if (empty($this->projectz)) {
            return 'No Project';
        } else {
            return $this->projectz->projectname;
        };
    }

    public function getEmployeeNameAttribute()
    {
        return $this->employeez->lname . ', ' . $this->employeez->fname;
    }
}
