<?php

namespace Tests\Feature\Auth;

use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class RegistrationTest extends TestCase
{
    use DatabaseMigrations, RefreshDatabase;

    public function testNewRegistration()
    {
        $password = str_random(8);

        $res = $this->post('register', [
            'name'                  => 'User Name',
            'email'                 => 'user@leqaa.org',
            'password'              => $password,
            'password_confirmation' => $password,
        ]);

        $res->assertStatus(200);
    }
}
