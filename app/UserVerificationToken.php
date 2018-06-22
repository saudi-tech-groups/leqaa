<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Str;

class UserVerificationToken extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'user_id',
        'token',
    ];

    /**
     * @param \App\User $user
     *
     * @return \App\UserVerificationToken
     */
    public static function generate(User $user)
    {
        return static::query()->create([
            'user_id' => $user->id,
            'token'   => Str::random(40),
        ]);
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
