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
        'prixMoyen', // Database column name (matches migration)
        'horaires',
        'telephone',
        'image',
        'stadeId' // Database column name
    ];

    public $timestamps = false;
    
}
