<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Security extends Model
{
    public $timestamps = false;
    protected $guarded = [];

    public function prices() {
    	return $this->hasMany('App\Price');
    }
}
