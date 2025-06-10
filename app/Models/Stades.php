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


    public function hotels()
    {
        return $this->hasMany(Hotels::class, 'stadeId', 'id');
    }

    public function activities()
    {
        return $this->hasMany(Activity::class, 'stade_id', 'id');
    }
}
