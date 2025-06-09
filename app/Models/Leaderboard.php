<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Leaderboard extends Model
{
    protected $fillable = ['player_name', 'score', 'accuracy', 'wpm'];
}
