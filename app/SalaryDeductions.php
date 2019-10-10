<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class SalaryDeductions extends Model
{
    public $timestamps = false;

    protected $table = 'salarydeductions';

    protected $fillable = ['employeeid', 'deductiontypeid', 'amount', 'date'];

    public $primaryKey = 'salarydeductionsid';



    public function employeez()
    {
        return $this->belongsTo('App\Employee', 'employeeid');
    }
    public function deductionz()
    {
        return $this->belongsTo('App\Deduction', 'deductiontypeid');
    }
    public function deductionlogz()
    {
        return $this->hasMany('App\SalaryDeductionsLogs', 'salarydeductionsid');
    }
}
