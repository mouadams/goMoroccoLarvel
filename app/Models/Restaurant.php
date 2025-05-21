<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;


class Restaurant extends Model
{
    use HasFactory;
    

    protected $fillable = [
        'nom',
        'cuisine',
        'description',
        'adresse',
        'note',
        'distance',
        'prixMoyen', 
        'horaires',
        'telephone',
        'image',
        'stadeId' 
    ];

    public $timestamps = false;
    
}
