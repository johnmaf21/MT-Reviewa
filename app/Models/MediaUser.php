<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\User;
use App\Models\Watchlist;

class MediaUser extends Model
{
    use HasFactory;
    public $timestamps = false;

    protected $fillable = [
                    'media_id',
                    'media_type',
                    'last_watched',
                    'is_completed',
                    'has_liked',
                    'has_reaction',
                    'completion'
                ];

    protected $casts = [
            'media_id' => 'integer',
            'last_watched' => 'datetime',
            'is_completed' => 'boolean',
            'completion' => 'float',
            'has_liked' => 'boolean',
            'has_reaction' => 'boolean'
        ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function episodeUser(){
        return $this->hasMany(EpisodeUser::class);
    }

    public function watchlist()
        {
            return $this->hasMany(Watchlist::class);
        }
}
