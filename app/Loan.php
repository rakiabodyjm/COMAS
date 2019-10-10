<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Loan extends Model
{
    public $timestamps = false;

    protected $fillable = ['employeeid', 'loanid', 'amount', 'date'];
    protected $table ='loan';

    public $primaryKey = 'loanid';



    public function employeez()
    {
        return $this->belongsTo('App\Employee', 'employeeid');
    }


}
