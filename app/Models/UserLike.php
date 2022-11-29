<?php

namespace App\Models;

use App\Models\UserComment;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserLike extends Model
{
    use HasFactory;

     public function userComment()
    {
        return $this->belongsTo(UserComment::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
