<?php

namespace App\Models;

use App\Models\UserComment;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Fortify\TwoFactorAuthenticatable;
use Laravel\Sanctum\HasApiTokens;
use App\Models\EpisodeUser;
use App\Models\Follower;
use App\Models\ListType;
use App\Models\MediaUser;
use App\Models\UserLike;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable, TwoFactorAuthenticatable;

    /**
     * The attributes that are mass assignable.
     *
     * @var string[]
     */
    protected $fillable = [
        'username',
        'email',
        'password',
        'dob',
        'profile_pic',
        'is_private'
    ];

    /**
     * The attributes that should be hidden for serialization.
     *a
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'dob' => 'date',
        'is_private' => 'boolean',
    ];

    public function episodeUser()
    {
        return $this->hasMany(EpisodeUser::class);
    }

    public function follower()
    {
        return $this->hasMany(Follower::class);
    }

    public function ListType()
    {
        return $this->hasMany(ListType::class);
    }

    public function mediaUser()
    {
        return $this->hasMany(MediaUser::class);
    }

    public function userComment()
    {
        return $this->hasMany(UserComment::class);
    }

    public function userLike()
    {
        return $this->hasMany(UserLike::class);
    }

    public function generateTwoFactorCode()
    {
        $this->timestamps = false;

        $this->two_factor_code = rand(100000, 999999);
        $this->two_factor_expires_at = now()->addMinutes(10);
        $this->save();
    }

    public function resetTwoFactorCode()
    {
        $this->timestamps = false;

        $this->two_factor_code = null;
        $this->two_factor_expires_at = null;
        $this->save();
    }
}
