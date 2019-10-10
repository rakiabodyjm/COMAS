<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Location extends Model
{
    public $timestamps = false;

    protected $table = 'location';

    protected $fillable = ['locationid', 'location', 'locationrate'];

    public $primaryKey = 'locationid';



    public function projectz()
    {
        return $this->hasMany('App\Project', 'projectid');
    }
    public function employeez()
    {
        return $this->hasMany('App\Employee', 'employeeid');
    }
}
