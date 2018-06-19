<?php

namespace App;

use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use Notifiable, SoftDeletes;

    protected $fillable = [
        'name',
        'email',
        'password',
        'verified'
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    public function groups()
    {
        return $this->belongsToMany(Group::class);
    }

    public function verifyUser()
    {
        return $this->hasOne(VerifyUser::class , 'user_id');
    }
}
