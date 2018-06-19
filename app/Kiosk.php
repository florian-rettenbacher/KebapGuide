<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Kiosk extends Model
{
    public function admin(){
    	return $this->belongsTo('App\User');
    }
}
