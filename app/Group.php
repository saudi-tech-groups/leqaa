<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Group extends Model
{
    protected $fillable = [
        'name',
        'description',
    ];

    public function organizers()
    {
        return $this->belongsToMany(User::class);
    }

    public function members()
    {
        return $this->hasManyThrough(User::class, GroupMembership::class);
    }

    public function events()
    {
        return $this->hasMany(Event::class);
    }

    public function topics()
    {
        return $this->belongsToMany(Topic::class);
    }
}
