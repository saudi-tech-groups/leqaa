<?php

namespace Tests\Feature\Auth;

use App\User;
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

        $user = User::where('email', 'user@leqaa.org')->firstOrFail();

        $this->assertFalse($user->isVerified());

        $response->assertSeeText('Please check your email to activate your account.');
    }

    public function testVerification()
    {
        $user = factory(User::class)->create();
        $token = $user->verificationToken;

        $this->assertFalse($user->isVerified());

        $url = route('email_verify', [base64_encode($user->email), $token->token]);

        $response = $this->followingRedirects()
            ->get($url);

        $response->assertOk();
        $user->refresh();

        $this->assertTrue($user->isVerified());
    }
}
