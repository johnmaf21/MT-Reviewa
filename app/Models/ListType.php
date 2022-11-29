<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\User;
use App\Models\WatchList;

class ListType extends Model
{
    use HasFactory;

    public $timestamps = false;

    protected $fillable = [
                        'name',
                        'date_created',
                        'date_updated'
                    ];

    protected $casts = [
            'date_created' => 'datetime',
            'date_updated' => 'datetime'
        ];

    public function user()
        {
            return $this->belongsTo(User::class);
        }

    public function watchlist()
        {
            return $this->hasMany(WatchList::class);
        }
}
