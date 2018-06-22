<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class GroupMembership extends Model
{
    /**
     * @param \App\Group $group
     * @param \App\User  $user
     *
     * @return \App\GroupMembership
     */
    public static function associateOrganizer(Group $group, User $user)
    {
        $membership = new static();

        $membership->group()->associate($group);
        $membership->user()->associate($user);
        $membership->type = GroupMembershipType::ORGANIZER;

        $membership->save();

        return $membership;
    }

    public function group()
    {
        return $this->belongsTo(Group::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
