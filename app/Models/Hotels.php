<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Hotels extends Model
{
    use HasFactory;

    protected $fillable = [
        'nom',
        'description',
        'etoiles',
        'ville',
        'image',
        'prix',
        'distance',
        'adresse',
        'phone', // Ensure this matches your column name
        'wifi',
        'parking',
        'piscine',
        'stadeId', // Ensure this matches your column name
    ];


    public $timestamps = false;
}
