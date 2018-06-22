<?php

namespace App\Policies;

use App\Group;
use App\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class GroupPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view the group.
     *
     * @param \App\User  $user
     * @param \App\Group $group
     *
     * @return mixed
     */
    public function view(User $user, Group $group)
    {
        return true;
    }

    /**
     * Determine whether the user can create groups.
     *
     * @param \App\User $user
     *
     * @return mixed
     */
    public function create(User $user)
    {
        return $user->isVerified();
    }

    /**
     * Determine whether the user can join the group.
     *
     * @param \App\User  $user
     * @param \App\Group $group
     *
     * @return mixed
     */
    public function join(User $user, Group $group)
    {
        return $user->isVerified();
    }

    /**
     * Determine whether the user can update the group.
     *
     * @param \App\User  $user
     * @param \App\Group $group
     *
     * @return mixed
     */
    public function update(User $user, Group $group)
    {
        return $user->isVerified()
            && $group->organizers()->find($user->id) !== null;
    }

    /**
     * Determine whether the user can delete the group.
     *
     * @param \App\User  $user
     * @param \App\Group $group
     *
     * @return mixed
     */
    public function delete(User $user, Group $group)
    {
        return $user->isVerified()
            && $group->organizers()->find($user->id) !== null;
    }
}
