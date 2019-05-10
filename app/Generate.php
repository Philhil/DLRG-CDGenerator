<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Generate extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
    ];


    public function users()
    {
        return $this->belongsToMany('App\User', 'generate_user');
    }

    public function gliederung()
    {
        return $this->hasOne('App\Gliederung');
    }

    public function format()
    {
        return $this->hasOne('App\Format');
    }
}
