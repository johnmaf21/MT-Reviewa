<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\UserComment;
use App\Models\User;

class UserReply extends Model
{
    use HasFactory;

    public $timestamps = false;

    protected $table ="user_replys";

    protected $fillable = [
                        'comment',
                        'date_posted'
                    ];

    protected $casts = [
                'date_posted' => 'datetime',
            ];

    public function originalComment()
    {
        return $this->belongsTo(UserComment::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
