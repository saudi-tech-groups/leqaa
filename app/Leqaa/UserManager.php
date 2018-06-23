<?php

namespace App\Leqaa;

use Auth;
use App\User;
use Laravel\Socialite\AbstractUser;

class UserManager
{
    public static $providers = ['google','github','twitter'];

    public static function loginSocialUser(AbstractUser $user, string $service) : User
    {
        $appUser = auth()->user() ?? static::createOrFindUser($user, $service);

        $serviceIdColumn = $service . '_id';
        $serviceUpdatedAtColumn = $service .'_updated_at';

        $appUser->$serviceIdColumn = $user->getId();
        $appUser->$serviceUpdatedAtColumn = now();
        $appUser->save();

        static::loginUser($appUser);

        return $appUser;
    }

    public static function loginUser(User $user)
    {
        Auth::loginUsingId($user->id, true);
    }

    public static function createOrFindUser(AbstractUser $user, string $service) : User
    {
        $appUser = User::where($service . '_id', $user->getId())->first();

        if(is_null($appUser))
            return static::createUser($user);

        return $appUser;
    }

    public static function createUser(AbstractUser $user) : User
    {
        $appUser = new User;

        return $appUser->fill([
            'name' => $user->getName(),
            'email' => $user->getEmail(),
            'verified' => false, // TODO: or true?
            'password' => bcrypt(str_random(40)), // TODO: need review!
        ]);
    }

    public static function getProviders()
    {
        return static::$providers;
    }

}
