<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Holidays extends Model
{
    public $timestamps = false;
    protected $fillable = ['date'];
    protected $table ='holidays';

    public $primaryKey = 'holidaysid';

}
