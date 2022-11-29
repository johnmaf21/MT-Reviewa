<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Watchlist;

class MovieWatchlist extends Model
{
    use HasFactory;

    public $timestamps = false;

    public function watchlist()
    {
        return $this->belongsTo(Watchlist::class);
    }
}
