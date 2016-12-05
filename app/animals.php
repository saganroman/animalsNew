<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Animals extends Model
{
    public $timestamps = false;

    public function species()
    {
        return $this->belongsTo('App\Species');
    }
    public function breed()
    {
        return $this->belongsTo('App\Breeds');
    }
}
