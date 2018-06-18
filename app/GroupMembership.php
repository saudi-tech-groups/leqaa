<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class GroupMembership extends Model
{
    const OWNER = 'newOwner';

    /**
     * @param \App\Group $group
     * @param \App\User  $user
     *
     * @return \App\GroupMembership
     */
    public static function newOwner(Group $group, User $user)
    {
        $membership = new static();

        $membership->type = GroupMembership::OWNER;
        $membership->group()->associate($group);
        $membership->user()->associate($user);

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
