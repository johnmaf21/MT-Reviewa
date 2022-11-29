<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EpisodeUser extends Model
{
    use HasFactory;

    protected $fillable = [
                    'episode_id',
                    'season',
                    'episode',
                    'is_watched',
                    'date_completed',
                    'has_liked'
                ];

    protected $casts = [
            'episode_id' => 'integer',
            'season' => 'integer',
            'episode' => 'integer',
            'is_watched' => 'boolean',
            'date_completed' => 'datetime',
            'has_liked' => 'boolean'
        ];


    public function mediaUser()
    {
        return $this->belongsTo(MediaUser::class);
    }

    public function currentEpisode(){
        return $this->hasOne(MediaUser::class);
    }
}
