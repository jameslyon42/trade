<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Price extends Model
{
    public $timestamps = false;
    protected $guarded = [];
    protected $dates = ['timestamp'];

    public function security() {
    	return $this->belongsTo('App\Security');
    }
}
