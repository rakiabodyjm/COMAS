<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class SalaryDeductionsLogs extends Model
{
    public $timestamps = false;

    protected $table = 'salarydeductionlogs';

    protected $fillable = ['salarydeductionsid', 'sdlogs_date', 'sdlogs_amount'];

    public $primaryKey = 'logs_id';



    public function salarydeductionz()
    {
        return $this->belongsTo('App\SalaryDeductions', 'salarydeductionsid');
    }
    public function employeez()
    {
        return $this->hasMany('App\Employee', 'logs_id');
    }
}
