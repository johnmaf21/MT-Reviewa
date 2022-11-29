<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\User;
use App\Models\Review;
use App\Models\UserReply;
use App\Models\UserLike;

class UserComment extends Model
{
    use HasFactory;

    public $timestamps = false;

    protected $fillable = [
                    'comment',
                    'date_posted'
                ];

    protected $casts = [
            'date_posted' => 'datetime',
        ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function review()
    {
        return $this->belongsTo(Review::class);
    }

    public function userLike()
    {
        return $this->hasMany(UserLike::class);
    }

    public function userReply()
    {
        return $this->hasMany(UserReply::class);
    }
}
