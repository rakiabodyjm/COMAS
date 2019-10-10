<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Inventory extends Model
{

    public $timestamps = false;

    protected $fillable = ['inventoryid', 'name', 'classification', 'quantity', 'restrictionid'];
    protected $table = 'inventory';

    public $primaryKey = 'inventoryid';
    public function inventorytransferz()
    {
        return $this->hasMany('App\InventoryTransfer', 'projectid');
    }

    public function skillz()
    {
        return $this->hasOne('App\Skill', 'skillid', 'restrictionid');
    }
}
