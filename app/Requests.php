<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Requests extends Model
{
    public $timestamps = false;

    protected $fillable = ['requestid', 'inventoryname', 'quantity', 'profrom', 'proto', 'employeename', 'date'];
    protected $table = 'request';


    public $primaryKey = 'requestid';

    public function inventorytransferz()
    {
        return $this->belongsTo('App\InventoryTransfer', 'transferid');
    }
}
