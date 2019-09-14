<?php

namespace Lucid;

use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class UserEmailLoginToken extends Model
{
    protected $table = "users_email_login_tokens";

    protected $fillable = ['token'];

    const TOKEN_EXPIRY = 130;

    public function user() {
        return $this->belongsTo(User::class);
    }

    public function  getRouteKeyName() {
        return 'token';
    }

    public function isExpired() {
        return $this->created_at->diffInSeconds(Carbon::now()) > self::TOKEN_EXPIRY;
    }

    public function belongsToEmail($email) {
        return (bool) ($this->user->where('email',$email)->count()===1);
    }
}
