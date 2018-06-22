<?php

use Faker\Generator as Faker;

/*
|--------------------------------------------------------------------------
| Model Factories
|--------------------------------------------------------------------------
|
| This directory should contain each of the model factory definitions for
| your application. Factories provide a convenient way to generate new
| model instances for testing / seeding your application's database.
|
*/

$factory->define(App\GroupMembership::class, function (Faker $faker) {
    return [
        'type'        => App\GroupMembershipType::ORGANIZER,
        'user_id'     => function () {
            return factory(App\User::class)->create()->id;
        },
        'group_id'    => function () {
            return factory(App\Group::class)->create()->id;
        },
    ];
});

$factory->state(App\GroupMembership::class, 'member', function () {
    return [
        'type' => App\GroupMembershipType::MEMBER,
    ];
});
