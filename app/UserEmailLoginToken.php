<?php

namespace Lucid;

use Illuminate\Database\Eloquent\Model;

class UserEmailLoginToken extends Model
{
    protected $table = "users_email_login_tokens";

    protected $fillable = ['token'];

    public function user() {
        return $this->belongsTo(User::class);
    }

    public function  getRouteKeyName() {
        return 'token';
    }
}
