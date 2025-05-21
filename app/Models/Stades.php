<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Stades extends Model
{
    use HasFactory;
    protected $table = 'stades';
    protected $fillable = ["id", "nom", "ville", "capacite", "image","description","latitude","longitude","annee_construction"];

    public $timestamps = false;
}
