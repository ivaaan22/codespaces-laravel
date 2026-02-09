<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Movie extends Model
{
    use HasFactory;

    // $fillable protege contra mass assignment: solo estos campos pueden ser asignados masivamente
    // Evita que usuarios maliciosos modifiquen campos como 'id' o timestamps mediante create()/update()
    protected $fillable = [
        'title',
        'description',
        'genre',
        'release_year',
        'duration',
        'director',
        'poster_url',
        'rating',
    ];
}
