<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Format extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
    ];

    public function gliederung()
    {
        return $this->hasOne('App\Gliederung');
    }
}
