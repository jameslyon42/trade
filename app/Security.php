<?php

namespace Trade;

use Illuminate\Database\Eloquent\Model;

class Security extends Model
{
    public $timestamps = false;
    protected $guarded = [];

    public function prices() {
    	return $this->hasMany('Trade\Price');
    }
}
