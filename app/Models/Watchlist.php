<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\ListType;
use App\Models\MediaUser;
use App\Models\TVWatchlist;
use App\Models\MovieWatchlist;

class Watchlist extends Model
{
    use HasFactory;

    public function listType()
    {
        return $this->belongsTo(ListType::class);
    }

    public function mediaUser()
    {
        return $this->belongsTo(MediaUser::class);
    }

    public function tvWatchlist()
    {
        return $this->hasMany(TVWatchlist::class);
    }

    public function movieWatchlist()
    {
        return $this->hasMany(MovieWatchlist::class);
    }
}
