<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class photo extends Model
{
    use HasFactory;
    protected $table = 'photo';

    protected $fillable = [
        'name',
        'description',
        'photo'
    ];
}
