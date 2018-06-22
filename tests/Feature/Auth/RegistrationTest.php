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

        $response = $this->followingRedirects()
            ->post('auth/register', [
                'name'                  => 'User Name',
                'email'                 => 'user@leqaa.org',
                'password'              => $password,
                'password_confirmation' => $password,
            ]);

        $response->assertSeeText('Please check your email to activate your account.');
    }
}
