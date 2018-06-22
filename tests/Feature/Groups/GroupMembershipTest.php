<?php

namespace Tests\Feature\Groups;

use App\Group;
use App\GroupMembership;
use App\GroupMembershipType;
use App\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class GroupMembershipTest extends TestCase
{
    use RefreshDatabase;

    public function testOrganizerMembership()
    {
        $user = factory(User::class)->create();
        $group = factory(Group::class)->create();

        $membership = factory(GroupMembership::class)->create([
            'user_id'  => $user->id,
            'group_id' => $group->id,
        ]);

        $this->assertEquals($membership->type, GroupMembershipType::ORGANIZER);
        $this->assertCount(1, $user->groups);
        $this->assertCount(1, $group->organizers);
        $this->assertCount(1, $group->members);
    }
}
