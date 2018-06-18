<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Event extends Model
{
    public function group()
    {
        return $this->belongsTo(Group::class);
    }

    public function hosts()
    {
        return $this->belongsToMany(User::class);
    }
}
