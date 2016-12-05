<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Species extends Model
{
    public function animals()
    {
        return $this->hasOne('App\Animals');
    }

}
