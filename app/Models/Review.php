<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\UserComment;

class Review extends Model
{
    use HasFactory;

    protected $fillable = [
                    'media_id',
                    'media_type',
                    'total_comments',
                    'total_reactions',
                ];

    protected $casts = [
            'media_id' => 'integer',
            'total_comments' => 'integer',
            'total_reactions' => 'integer',

        ];

    public function userComment()
    {
        return $this->hasMany(UserComment::class);
    }
}
