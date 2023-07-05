<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class unknown extends Model
{
    use HasFactory;
    protected $fillable = [
        'word',
        'translate',
        'repetition',
        'root',
        'level',
        'difficultyRate',
        'type',
        'user',
    ];
    protected $table = 'unknowns';
}
