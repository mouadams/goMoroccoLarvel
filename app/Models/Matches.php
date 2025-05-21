<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Matches extends Model
{
    protected $fillable = [
        'stadeId',
        'equipe1',
        'equipe2',
        'date',
        'heure',
        'phase',
        'groupe',
        'score1',
        'score2',
        'termine',
    ];

   public $timestamps = false;
}
