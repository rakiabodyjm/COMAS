<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Skill extends Model
{

    public $timestamps = false;

    protected $fillable = ['description', 'salaryrate'];
    protected $table = 'skills';

    public $primaryKey = 'skillid';

    public function employeez()
    {
        return $this->hasMany('App\Employee', 'employeeid');
    }

    public function inventoryz()
    {
        return $this->hasMany('App\Inventory', 'restrictionid', 'skillid', 'skillid');
    }
}
