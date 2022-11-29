<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Watchlist;

class TVWatchlist extends Model
{
    use HasFactory;

    protected $table = "tv_watchlists";

    public $timestamps = false;

    public function watchlist()
        {
            return $this->belongsTo(Watchlist::class);
        }
}
