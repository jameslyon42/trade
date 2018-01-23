<?php

namespace App\Models\Entities;

use Illuminate\Database\Eloquent\Model;

class Portfolio extends Model
{
    protected $guarded = [];

    public function user() {
        return $this->belongsTo('App\Models\Entities\User');
    }

    public function positions() {
        return $this->hasMany('App\Models\Entities\Position');
    }
}
