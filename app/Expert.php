<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Expert extends Model
{
    protected $fillable = ["name", "avatar", "expert", "timezone", "country", "start_work", "end_work"];

    public function appointments(){
        return $this->hasMany(Appointment::class);
    }
}
