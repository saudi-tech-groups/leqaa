<?php

namespace Tests\Feature\Auth;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class RegistrationTest extends TestCase
{
    use RefreshDatabase;

    public function testNewRegistration()
    {
        $password = str_random(8);

        $response = $this->post('auth/register', [
            'name'                  => 'User Name',
            'email'                 => 'user@leqaa.org',
            'password'              => $password,
            'password_confirmation' => $password,
        ]);

        $response->dump();
        $response->assertStatus(200);
    }
}
