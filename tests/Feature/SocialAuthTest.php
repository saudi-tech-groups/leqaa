<?php

namespace Tests\Feature;

use Auth;
use Session;
use Mockery;
use Socialite;
use App\User;
use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class SocialAuthTest extends TestCase
{
    use RefreshDatabase;

    public function test_services_login_route_exists()
    {

        $googleResponse = $this->getSocialAuthResponse('google','socialAuth.redirect');
        $googleResponse->assertRedirect("fake.google.login");

        $githubResponse = $this->getSocialAuthResponse('github','socialAuth.redirect');
        $githubResponse->assertRedirect("fake.github.login");

        $twitterResponse = $this->getSocialAuthResponse('twitter','socialAuth.redirect');
        $twitterResponse->assertRedirect("fake.twitter.login");
    }

    public function test_unauthenticated_and_unregistered_user_logins_with_multiple_services()
    {
        $this->assertNull(auth()->user());

        $googleResponse = $this->getSocialAuthResponse('google','socialAuth.callback');
        $googleResponse->assertRedirect('/home');
        $googleResponse->assertStatus(302);
        $this->assertNotNull(auth()->user()->google_id);
        $this->assertNotNull(auth()->user()->google_updated_at);

        $githubResponse = $this->getSocialAuthResponse('github','socialAuth.callback');
        $githubResponse->assertRedirect('/home');
        $githubResponse->assertStatus(302);
        $this->assertNotNull(auth()->user()->github_id);
        $this->assertNotNull(auth()->user()->github_updated_at);

        $twitterResponse = $this->getSocialAuthResponse('twitter','socialAuth.callback');
        $twitterResponse->assertRedirect('/home');
        $twitterResponse->assertStatus(302);
        $this->assertNotNull(auth()->user()->twitter_id);
        $this->assertNotNull(auth()->user()->twitter_updated_at);

        // one user will be created since the first login created and logged in that user
        $this->assertEquals(1, User::all()->count());
    }

    public function test_authinticated_user_links_google_and_twitter_accounts()
    {
        $user = factory(User::class)->create();
        $this->actingAs($user, 'web');

        $this->assertNotNull(auth()->user());

        $googleResponse = $this->getSocialAuthResponse('google','socialAuth.callback');
        $googleResponse->assertRedirect('/home');
        $this->assertNotNull(auth()->user()->google_id);
        $this->assertNotNull(auth()->user()->google_updated_at);

        $this->getSocialAuthResponse('twitter','socialAuth.callback');
        $this->assertNotNull(auth()->user()->twitter_id);
        $this->assertNotNull(auth()->user()->twitter_updated_at);

        $this->assertEquals(1, User::all()->count());
    }

    public function test_registered_user_login_with_already_linked_google_account()
    {
        // normal login
        $user = factory(User::class)->create();
        $this->actingAs($user, 'web');
        // associate google account
        $this->getSocialAuthResponse('google','socialAuth.callback');
        // logout
        auth()->logOut();
        $this->assertNull(auth()->user());
        // login with google
        $googleResponse = $this->getSocialAuthResponse('google','socialAuth.callback');
        $googleResponse->assertRedirect('/home');
        // assert logged in
        $this->assertNotNull(auth()->user());

    }

    protected function getSocialAuthResponse($service = "github", $route = 'socialAuth.redirect')
    {
        $socialiteProvider = $this->mockSocialite($service);

        if(str_contains($route, 'callback'))
        {
            $abstractUser = $this->mockSocialiteUser($service);
            $socialiteProvider->shouldReceive('user')->andReturn($abstractUser);
        }

        $response = $this->get(route($route, ['proivder' => $service]));

        return $response;
    }

    protected function mockSocialite($service)
    {

        $provider = Mockery::mock('Laravel\Socialite\Contracts\Provider');
        $provider->shouldReceive('redirect')->andReturn(redirect("fake.{$service}.login"));

        if($service === 'github')
            $provider->shouldReceive('scopes')->andReturn($provider);

        Socialite::shouldReceive('driver')->with($service)->andReturn($provider);

        return $provider;
    }

    protected function mockSocialiteUser($service)
    {
        $mockedClass = 'Laravel\Socialite\Two\User';

        // only twitter still uses one auth
        if($service === 'twitter')
            $mockedClass = 'Laravel\Socialite\One\User';

        $abstractUser = Mockery::mock($mockedClass);
        $abstractUser->token = '1234';
        $abstractUser->tokenSecret = '12345';
        $abstractUser->shouldReceive('getId')
        ->andReturn(123)
        ->shouldReceive('getEmail')
        ->andReturn('socialauth@leqaa.org')
        ->shouldReceive('getNickname')
        ->andReturn('FooBar')
        ->shouldReceive('getName')
        ->andReturn('Mohannad Najjar')
        ->shouldReceive('getAvatar')
        ->andReturn('https://via.placeholder.com/100x100');

        return $abstractUser;
    }
}