<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Deduction extends Model
{
    public $timestamps = false;

    protected $fillable = ['description'];
    protected $table ='deductiontype';

    public $primaryKey = 'deductiontypeid';

    public function salarydeductionz()
    {
        return $this->hasMany('App\SalaryDeductions', 'salarydeductionsid');
    }
    
}
