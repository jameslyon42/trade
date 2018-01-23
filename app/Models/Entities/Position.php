<?php

namespace App\Models\Entities;

use Illuminate\Database\Eloquent\Model;

class Position extends Model
{
    protected $guarded = [];

    public $timestamps = false;

    public function portfolio() {
        return $this->belongsTo('App\Models\Entities\Portfolio');
    }

    public function security() {
        return $this->belongsTo('App\Models\Entities\Security');
    }
}
