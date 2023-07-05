<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class known extends Model
{
    use HasFactory;

    protected $fillable = [
        'word',
        'translate',
        'root',
        'level',
        'type',
        'user',
    ];
}
