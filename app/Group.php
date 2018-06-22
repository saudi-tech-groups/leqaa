<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Group extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'name',
        'description',
    ];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function organizers()
    {
        return $this->belongsToMany(User::class, 'group_memberships')
            ->withPivot('id', 'type')
            ->withTimestamps()
            ->where('type', GroupMembershipType::ORGANIZER);
    }

    public function members()
    {
        return $this->belongsToMany(User::class, 'group_memberships')
            ->withPivot('id', 'type')
            ->withTimestamps();
    }

    public function events()
    {
        return $this->hasMany(Event::class);
    }
}
