<?php

namespace App\Models\Entities;

use Illuminate\Database\Eloquent\Model;

class Security extends Model
{
    public $timestamps = false;
    protected $guarded = [];

    public function prices() {
    	return $this->hasMany('App\Models\Entities\Price');
    }
}
