<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Activity extends Model
{
    protected $fillable = [
        'name',
        'description',
        'image',
        'stade_id', // Laravel uses snake_case for database columns by convention
        'category',
        'price',
        'address',
        'rating',
    ];


    public function stade()
    {
        return $this->belongsTo(Stades::class, 'stade_id');
    }
}
