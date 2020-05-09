<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Appointment extends Model
{
    protected $fillable = ["client_name", "expert_id", "start", "end"];

    function expert(){
        return $this->belongsTo(Expert::class);
    }
}
