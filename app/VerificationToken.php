<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class VerificationToken extends Model
{
    use SoftDeletes;

    protected $table = 'user_verification_tokens';

    protected $fillable = [
        'user_id',
        'token',
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
