<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Gliederung extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
    ];

    public function generates()
    {
        return $this->hasMany('App\Generates');
    }
}
