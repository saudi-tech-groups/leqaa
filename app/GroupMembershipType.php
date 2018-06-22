<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class GroupMembershipType extends Model
{
    const ORGANIZER = 'ORGANIZER';
    const MEMBER = 'MEMBER';

    protected $primaryKey = 'type';
}
