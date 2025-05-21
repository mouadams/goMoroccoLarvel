<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Equipes extends Model
{
    use HasFactory;

    protected $fillable = [
        'nom',
        'drapeau',
        'groupe',
        'abreviation',
        'confederation',
        'entraineur',
        'rang'
    ];

    public $timestamps = false;
    

    
}
