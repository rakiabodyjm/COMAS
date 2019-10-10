<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class InventoryTransfer extends Model
{

    public $timestamps = false;

    protected $fillable = ['transferid', 'inventoryid', 'projectname', 'employeeid', 'quantity', 'date'];
    protected $table = 'inventorytransfer';

    // protected $appends = ['loc_from', 'loc_cur'];
    public $primaryKey = 'transferid';
    public function inventoryz()
    {
        return $this->belongsTo('App\Inventory', 'inventoryid');
    }
    public function employeez()
    {
        return $this->belongsTo('App\Employee', 'employeeid');
    }
    public function project1()
    {
        return $this->hasOne('App\Project', 'projectid', 'projectname');
    }
    // public function project2()
    // {
    //     return $this->hasOne('App\Project','projectid', 'procurrent');

    // }
    // public function getLocFromAttribute()
    // {
    //     return $this->location;
    // }
    // public function getLocCurAttribute()
    // {
    //     return $this->location;
    // }

}
