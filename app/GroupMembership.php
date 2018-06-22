<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class GroupMembership extends Model
{
    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function group()
    {
        return $this->belongsTo(Group::class);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * @param \App\Group $group
     * @param \App\User  $user
     *
     * @return \App\GroupMembership
     */
    public static function associateOrganizer(Group $group, User $user)
    {
        return static::associate(GroupMembershipType::ORGANIZER, $group, $user);
    }

    /**
     * @param \App\Group $group
     * @param \App\User  $user
     *
     * @return \App\GroupMembership
     */
    public static function associateMember(Group $group, User $user)
    {
        return static::associate(GroupMembershipType::MEMBER, $group, $user);
    }

    /**
     * @param string     $type
     * @param \App\Group $group
     * @param \App\User  $user
     *
     * @return \App\GroupMembership
     */
    private static function associate($type, Group $group, User $user)
    {
        $membership = new static();

        $membership->group()->associate($group);
        $membership->user()->associate($user);
        $membership->type = $type;

        $membership->save();

        return $membership;
    }
}
